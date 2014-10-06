<?php
/**
 * Created by PhpStorm.
 * User: Poltoratskiy A.
 * Date: 02.10.14
 * Time: 16:53
 */
class Import1c extends CComponent
{
    protected $uploadPath = 'exchange';

    protected $xml = '';

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
        $fileName = Yii::app()->request->getQuery('filename');
        $result = file_put_contents(
            $this->getUploadPath($fileName),
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
        $this->xml = $this->getXml(Yii::app()->request->getQuery('filename'));
        if(!$this->xml)
            Yii::app()->end('Not found xml file!');

        // Import categories
        if(isset($this->xml->{"Классификатор"}->{"Группы"}))
            $this->importCategories($this->xml->{"Классификатор"}->{"Группы"});

        // Import properties
        // Свойства на данный момент не выгружаются
//        if(isset($this->xml->{"Классификатор"}->{"Свойства"}))
//            $this->importProperties();

        // Import products
        if(isset($this->xml->{"Каталог"}->{"Товары"}))
            $this->importProducts();

        // Import prices
//        if(isset($this->xml->{"ПакетПредложений"}->{"Предложения"}))
//            $this->importOffers();

        echo 'success'.PHP_EOL;
    }

    /**
     * Import catalog products
     */
    public function importProducts()
    {
        foreach($this->xml->{"Каталог"}->{"Товары"}->{"Товар"} as $product)
        {
            $createExId=false;
            $model=C1ExternalFinder::getObject(C1ExternalFinder::OBJECT_TYPE_PRODUCT, $product->{"Ид"});

            if(!$model)
            {
                $model = new StoreProduct;
                $model->type_id   = self::DEFAULT_TYPE;
                $model->price     = 0;
                $model->is_active = 1;
                $createExId=true;
            }

            $model->name=$product->{"Наименование"};
            $model->sku=$product->{"Артикул"};
            $model->save();

            // Create external id
            if($createExId===true)
                $this->createExternalId(C1ExternalFinder::OBJECT_TYPE_PRODUCT, $model->id, $product->{"Ид"});

            // Set category
            $categoryId=C1ExternalFinder::getObject(C1ExternalFinder::OBJECT_TYPE_CATEGORY,$product->{"Группы"}->{"Ид"}, false);
            $model->setCategories(array($categoryId), $categoryId);
        }
    }

    /**
     * Import catalog prices
     */
    public function importOffers()
    {
        foreach($this->xml->{"ПакетПредложений"}->{"Предложения"}->{"Предложение"} as $offer)
        {
            $product=C1ExternalFinder::getObject(C1ExternalFinder::OBJECT_TYPE_PRODUCT, $offer->{"Ид"});

            if($product)
            {
                $product->price=$offer->{"Цены"}->{"Цена"}->{"ЦенаЗаЕдиницу"};
                $product->quantity=$offer->{"Количество"};
                $product->save(false);
            }
        }
    }

    /**
     * @param $attribute_id
     * @param $value
     * @return StoreAttributeOption
     */
    public function addOptionToAttribute($attribute_id, $value)
    {
        // Add option
        $option = new StoreAttributeOption;
        $option->attribute_id = $attribute_id;
        $option->value = $value;
        $option->save();
        return $option;
    }

    /**
     * @param $data
     * @param null|StoreCategory $parent
     */
    public function importCategories($data, $parent=null)
    {
        foreach($data->{"Группа"} as $category)
        {
            // Find category by external id
            $model = Category::model()->find('external_id = :ext_id', array(':ext_id' => $category->{"Ид"}));

            if(!$model)
            {
                $model = new Category;
                $model->name = $category->{"Наименование"};
                $model->alias = yupe\helpers\YText::translit($category->{"Наименование"});
                $model->description = Yii::t('ShopModule.shop', 'It unloaded from 1c');
                $model->lang = Yii::app()->getLanguage();
                $model->status = Category::STATUS_MODERATION;
                $model->external_id = $category->{"Ид"};

                if($parent instanceof CActiveRecord)
                    $model->parent_id = $parent->id;
            }

            $model->save();

            // Process subcategories
            if(isset($category->{"Группы"}))
                $this->importCategories($category->{"Группы"}, $model);
        }
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
}