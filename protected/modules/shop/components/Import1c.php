<?php
/**
 * Created by PhpStorm.
 * User: Poltoratskiy A.
 * Date: 02.10.14
 * Time: 16:53
 *
 * /shop/exchange/d41d8cd98f00b204e9800998ecf8427e?type=catalog&mode=import&filename=offers.xml
 */
class Import1c extends CComponent
{
    const IMPORT_TYPE_CATEGORIES    = 'import_categories';
    const IMPORT_TYPE_GOODS         = 'import_goods';
    const IMPORT_TYPE_OFFERS        = 'import_offers';
    const IMPORT_TYPE_ATTRIBUTES    = 'import_attributes';

    protected $uploadPath = 'exchange';

    /**
     * @param $type
     * @param $mode
     */
    public static function processRequest($type, $mode)
    {
        $method='command'.ucfirst($type).ucfirst($mode);
        $import=new self;
        if(method_exists($import, $method))
            $import->$method();
    }

    /**
     * Auth
     */
    public function commandCatalogCheckauth()
    {
        echo 'success'.PHP_EOL;
        echo Yii::app()->session->sessionName.PHP_EOL;
        echo Yii::app()->session->sessionId.PHP_EOL;
    }

    /**
     * Initialize catalog.
     */
    public function commandCatalogInit()
    {
        $fileSize = (int)(ini_get('upload_max_filesize'))*1024*1024;
        echo 'zip=no'.PHP_EOL;
        echo 'filelimit='.$fileSize.PHP_EOL;
    }

    /**
     * Save file
     */
    public function commandCatalogFile()
    {
        $result = file_put_contents(
            $this->getUploadPath(Yii::app()->request->getQuery('filename')),
            Yii::app()->request->getRawBody()
        );
        if($result)
            echo 'success'.PHP_EOL;
    }

    /**
     * Import
     */
    public function commandCatalogImport()
    {
        $xml = $this->getXml(Yii::app()->request->getQuery('filename'));
        if(!$xml)
            Yii::app()->end('Not found xml file!');

        // Import attributes
        /*if(isset($xml->collection) && !$this->check(self::IMPORT_TYPE_ATTRIBUTES))
        {
            if($this->importAttributes($xml->collection))
                Yii::app()->session[self::IMPORT_TYPE_ATTRIBUTES] = true;
        }*/

        // Import categories
        if(isset($xml->{"Классификатор"}->{"Группы"}) && !$this->check(self::IMPORT_TYPE_CATEGORIES))
        {
            if($this->importCategories($xml->{"Классификатор"}->{"Группы"}))
                Yii::app()->session[self::IMPORT_TYPE_CATEGORIES] = true;
        }

        // Import products
        if(isset($xml->{"Каталог"}->{"Товары"}) && !$this->check(self::IMPORT_TYPE_GOODS))
        {
            if($this->importProducts($xml->{"Каталог"}->{"Товары"}))
                Yii::app()->session[self::IMPORT_TYPE_GOODS] = true;
        }
        // Import offers
        if(isset($xml->{"ПакетПредложений"}->{"Предложения"}) && !$this->check(self::IMPORT_TYPE_OFFERS))
        {
            if($this->importOffers($xml->{"ПакетПредложений"}->{"Предложения"}))
                Yii::app()->session[self::IMPORT_TYPE_OFFERS] = true;
        }

        echo 'success'.PHP_EOL;
    }

    /**
     * Import catalog products
     */
    public function importProducts($data)
    {
        foreach($data->{"Товар"} as $product)
        {
            if(!$product->{"Группы"}->{"Ид"})
                continue;

            // ищем категорию, если не найдена то пропускаем
            $category = Category::model()->find('external_id = :ext_id', array(':ext_id' => (string)$product->{"Группы"}->{"Ид"}));
            if(!$category)
                continue;

            $model = Good::model()->find('external_id = :ext_id', array(':ext_id' => (string)$product->{"Ид"}));

            if(!$model)
            {
                $model              = new Good;
                $model->external_id = (string)$product->{"Ид"};
            }

            $model->name        = (string)$product->{"Наименование"};
            $model->description = CHtml::tag('p', array(), Yii::t('ShopModule.shop', 'It unloaded from 1c'));
            $model->article     = (string)$product->{"Артикул"};
            $model->category_id = $category->id;
            $model->save();
        }
        return true;
    }

    /**
     * Import catalog prices
     */
    public function importOffers($data)
    {
        foreach($data->{"Предложение"} as $offer)
        {
            $ids = explode('#', (string)$offer->{"Ид"});
            $good_ext_id  = $ids[0];
            $offer_ext_id = isset($ids[1]) ? $ids[1] : $ids[0];

            // ищем товар, если не найден то пропускаем
            $good = Good::model()->find('external_id = :ext_id', array(':ext_id' => $good_ext_id));
            if(!$good)
                continue;

            $model = Offer::model()->find('external_id = :ext_id', array(':ext_id' => $offer_ext_id));

            if(!$model)
            {
                $model              = new Offer;
                $model->good_id     = $good->id;
                $model->external_id = $offer_ext_id;
            }

            $model->name        = (string)$offer->{"Наименование"};
            $model->description = CHtml::tag('p', array(), Yii::t('ShopModule.shop', 'It unloaded from 1c'));
            $model->price       = (string)$offer->{"Цены"}->{"Цена"}->{"ЦенаЗаЕдиницу"};
            $model->status      = Offer::STATUS_ZERO;
            $model->save();
        }
        return true;
    }

    /**
     * @param $data
     * @param null $parent
     * @return bool
     */
    public function importCategories($data, $parent=null)
    {
        foreach($data->{"Группа"} as $category)
        {
            // Find category by external id
            $model = Category::model()->find('external_id = :ext_id', array(':ext_id' => (string)$category->{"Ид"}));

            if(!$model)
            {
                $model              = new Category;
                $model->name        = (string)$category->{"Наименование"};
                $model->description = CHtml::tag('p', array(), Yii::t('ShopModule.shop', 'It unloaded from 1c'));
                $model->lang        = Yii::app()->getLanguage();
                $model->status      = Category::STATUS_MODERATION;
                $model->external_id = (string)$category->{"Ид"};

                if($parent instanceof CActiveRecord)
                    $model->parent_id = $parent->id;

                $model->save();
            }

            // Process subcategories
            if(isset($category->{"Группы"})) {
                $this->importCategories($category->{"Группы"}, $model);
            }
        }
        return true;
    }

    /**
     * parse xml file from temp dir.
     * @param $xmlFileName
     * @return bool|object
     */
    public function getXml($xmlFileName)
    {
        $xmlFileName = str_replace('../','',$xmlFileName);
        $fullPath = $this->getUploadPath($xmlFileName);
        if(file_exists($fullPath) && is_file($fullPath))
            return simplexml_load_file($fullPath);
        else
            return false;
    }

    protected function getUploadPath($fileName)
    {
        $path = implode(DIRECTORY_SEPARATOR, array(
            Yii::app()->getModule('yupe')->uploadPath,
            Yii::app()->getModule('shop')->uploadPath,
            $this->uploadPath
        ));
        if(!file_exists($path)) {
            mkdir($path);
        }
        return $path.DIRECTORY_SEPARATOR.$fileName;
    }

    public function check($type)
    {
        return isset(Yii::app()->session[$type]) && Yii::app()->session[$type];
    }
}