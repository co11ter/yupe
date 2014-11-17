<?php

/**
 * Модель Offer
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.shop.models
 * @since 0.1
 * @editor Poltoratskiy A. <co11ter@mail.ru>
 *
 */

/**
 * This is the model class for table "offer".
 *
 * The followings are the available columns in table 'offer':
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property double $price
 * @property string $article
 * @property string $image
 * @property string $short_description
 * @property string $description
 * @property string $alias
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $user_id
 * @property string $change_user_id
 *
 * The followings are the available model relations:
 * @property User $changeUser
 * @property Good $good
 * @property User $user
 */
class Offer extends yupe\models\YModel implements IECartPosition
{
    const SPECIAL_NOT_ACTIVE = 0;
    const SPECIAL_ACTIVE     = 1;

    const STATUS_ZERO       = 0; // не отображается
    const STATUS_ACTIVE     = 1; // активный
    const STATUS_NOT_ACTIVE = 2; // скрытый

    public $attributeIds = array();

    /**
     * Свойство для проброса аттрибутов товара для поиска
     * @var array
     */
    public $goodAttributes = array();

    /**
     * Минимальная и максимальная цены выборки
     * @var int
     */
    public $minPrice = 0;
    public $maxPrice = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return offer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_offer}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, description, alias, good_id', 'required', 'except' => 'search'),
            array('name, description, short_description, image, alias, price, status, is_special', 'filter', 'filter' => 'trim'),
            array('name, alias, price, status, is_special', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('status, is_special, user_id, gallery_id, good_id', 'numerical', 'integerOnly' => true),
            array('status, is_special, user_id, gallery_id, good_id', 'length', 'max' => 11),
            array('price', 'numerical'),
            array('name, image', 'length', 'max' => 250),
            array('alias', 'length', 'max' => 150),
            array('status','in','range' => array_keys($this->statusList)),
            array('is_special','in','range' => array(0, 1)),
            array('alias', 'yupe\components\validators\YSLugValidator', 'message' => Yii::t('ShopModule.shop', 'Illegal characters in {attribute}')),
            array('alias', 'unique'),
            array('external_id', 'unique'),
            array('id, name, price, short_description, description, alias, status, create_time, update_time, user_id, change_user_id, is_special, offerAttributes, goodAttributes, gallery_id, good_id, minPrice, maxPrice, external_id, goodName', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'changeUser'        => array(self::BELONGS_TO, 'User', 'change_user_id'),
            'user'              => array(self::BELONGS_TO, 'User', 'user_id'),
            'good'              => array(self::BELONGS_TO, 'Good', 'good_id'),
            'gallery'           => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
            'offerAttributes'   => array(self::HAS_MANY, 'OfferHasAttribute', 'offer_id'),
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 't.status = :status',
                'params'    => array(':status' => self::STATUS_ACTIVE),
            ),
            'onHomePage' => array(
                'condition' => 't.is_special = :is_special',
                'params'    => array(':is_special' => self::SPECIAL_ACTIVE)
            ),
            'limitPrices' => array(
                'select' => 'CEILING(MAX(t.price)) as maxPrice, FLOOR(MIN(t.price)) as minPrice'
            ),
            'groupByGood' => array(
                'group' => 't.good_id'
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                => Yii::t('ShopModule.shop', 'ID'),
            'name'              => Yii::t('ShopModule.shop', 'Name'),
            'price'             => Yii::t('ShopModule.shop', 'Price'),
            'image'             => Yii::t('ShopModule.shop', 'Image'),
            'short_description' => Yii::t('ShopModule.shop', 'Short description'),
            'description'       => Yii::t('ShopModule.shop', 'Description'),
            'alias'             => Yii::t('ShopModule.shop', 'Alias'),
            'status'            => Yii::t('ShopModule.shop', 'Status'),
            'create_time'       => Yii::t('ShopModule.shop', 'Added'),
            'update_time'       => Yii::t('ShopModule.shop', 'Updated'),
            'user_id'           => Yii::t('ShopModule.shop', 'User'),
            'change_user_id'    => Yii::t('ShopModule.shop', 'Editor'),
            'is_special'        => Yii::t('ShopModule.shop', 'On home page'),
            'offerAttributes'   => Yii::t('ShopModule.shop', 'Attribute'),
            'gallery_id'        => Yii::t('ShopModule.shop', 'Gallery'),
            'good_id'           => Yii::t('ShopModule.shop', 'Good'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'                => Yii::t('ShopModule.shop', 'ID'),
            'name'              => Yii::t('ShopModule.shop', 'Name'),
            'price'             => Yii::t('ShopModule.shop', 'Price'),
            'image'             => Yii::t('ShopModule.shop', 'Image'),
            'short_description' => Yii::t('ShopModule.shop', 'Short description'),
            'description'       => Yii::t('ShopModule.shop', 'Description'),
            'alias'             => Yii::t('ShopModule.shop', 'Alias'),
            'status'            => Yii::t('ShopModule.shop', 'Status'),
            'create_time'       => Yii::t('ShopModule.shop', 'Added'),
            'update_time'       => Yii::t('ShopModule.shop', 'Edited'),
            'user_id'           => Yii::t('ShopModule.shop', 'User'),
            'change_user_id'    => Yii::t('ShopModule.shop', 'Editor'),
            'is_special'        => Yii::t('ShopModule.shop', 'On home page'),
            'offerAttributes'   => Yii::t('ShopModule.shop', 'Attribute'),
            'gallery_id'        => Yii::t('ShopModule.shop', 'Gallery'),
            'good_id'           => Yii::t('ShopModule.shop', 'Good'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param string $cid
     * @param string $name
     * @return CActiveDataProvider
     */
    public function search($cid = '', $name = '')
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->select = 't.*';
        $criteria->compare('id', $this->id, false);
        $criteria->compare('good_id', $this->good_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('is_special', $this->is_special, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('user_id', $this->user_id,true);
        $criteria->compare('change_user_id', $this->change_user_id, true);

        if($this->minPrice) {
            $criteria->compare('price', '>='.$this->minPrice, true);
        }
        if($this->maxPrice) {
            $criteria->compare('price', '<='.$this->maxPrice, true);
        }

        if($this->offerAttributes) {
            foreach($this->offerAttributes as $id => $value) {
                if($value) {
                    $criteria->mergeWith(array(
                        'join'=>'JOIN '.OfferHasAttribute::model()->tableName().' attr'.$id.' ON attr'.$id.'.offer_id = t.id'
                    ));
                    $criteria->compare('attr'.$id.'.attribute_id', $id, false);
                    if(is_array($value)) {
                        $criteria->addInCondition('attr'.$id.'.value', array_values($value));
                    } else {
                        $criteria->compare('attr'.$id.'.value', $value, false);
                    }
                }
            }
        }
        if($this->goodAttributes) {
            foreach($this->goodAttributes as $id => $value) {
                if($value) {
                    $criteria->mergeWith(array(
                        'join'=>'JOIN '.GoodHasAttribute::model()->tableName().' gattr'.$id.' ON gattr'.$id.'.good_id = t.good_id'
                    ));
                    $criteria->compare('gattr'.$id.'.attribute_id', $id, false);
                    if(is_array($value)) {
                        $criteria->addInCondition('gattr'.$id.'.value', array_values($value));
                    } else {
                        $criteria->compare('gattr'.$id.'.value', $value, false);
                    }
                }
            }
        }

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function behaviors()
    {

        $module = Yii::app()->getModule('shop');
        return array(
            'CTimestampBehavior' => array(
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute'   => 'create_time',
                'updateAttribute'   => 'update_time',
            ),
            'imageUpload' => array(
                'class'         =>'yupe\components\behaviors\FileUploadBehavior',
                'scenarios'     => array('insert','update'),
                'attributeName' => 'image',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'uploadPath'    => $module->uploadPath,
                'fileName' => array($this, 'generateFileName'),
            ),
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function generateFileName()
    {
        return md5($this->name . microtime(true) . uniqid());
    }

    public function beforeValidate()
    {
        $this->change_user_id = Yii::app()->user->getId();

        if ($this->isNewRecord) {
            $this->user_id = $this->change_user_id;
        }

        if (!$this->alias) {
            $this->alias = yupe\helpers\YText::translit($this->name);
        }

        return parent::beforeValidate();
    }

    public function getPermaLink()
    {
        return Yii::app()->createAbsoluteUrl('/shop/shop/show/', array( 'name' => $this->alias ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ZERO       => Yii::t('ShopModule.shop', 'Not available'),
            self::STATUS_ACTIVE     => Yii::t('ShopModule.shop', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('ShopModule.shop', 'Not active'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('ShopModule.shop', '*unknown*');
    }

    public function getSpecialList()
    {
        return array(
            self::SPECIAL_NOT_ACTIVE => Yii::t('ShopModule.shop', 'No'),
            self::STATUS_ACTIVE      => Yii::t('ShopModule.shop', 'Yes'),
        );
    }

    /**
     * @return string
     */
    public function getSpecial()
    {
        $data = $this->getSpecialList();
        return isset($data[$this->is_special]) ? $data[$this->is_special] : Yii::t('ShopModule.shop', '*unknown*');
    }

    /**
     * Получаем урл данного оффера
     * @return string
     */
    public function getUrl(){
        return '/shop/'.$this->good->category->alias.'/'.$this->alias;
    }

    public function getImageUrl()
    {
        if ($this->image) {
            return Yii::app()->baseUrl . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' .
            Yii::app()->getModule('shop')->uploadPath . '/' . $this->image;
        }

        return false;
    }

    public function getImageThumbnail($width = 137, $height = 130)
    {
        if (false !== $this->image) {

            $module = Yii::app()->getModule('shop');

            return Yii::app()->image->makeThumbnail(
                $this->image,
                $module->uploadPath,
                $width,
                $height,
                \Imagine\Image\ImageInterface::THUMBNAIL_INSET
            );
        }

        return false;
    }

    /**
     * category link
     * @return string html caregory link
     **/
    public function getCategoryLink()
    {
        return $this->good->category instanceof Category
            ? CHtml::link($this->good->category->name, array("/category/default/view", "id" => $this->good->category->id))
            : '---';
    }

    /**
     * Готовит массив с аттрибутами к сохранению
     * @return array
     */
    private function prepareAttrSave()
    {
        $result = array();
        foreach((array)$this->attributeIds as $attrId => $attrValue) {
            if(is_array($attrValue)) {
                foreach($attrValue as $value) {
                    $result[] = array(
                        'key' => $attrId,
                        'value' => $value
                    );
                }
            } else {
                $result[] = array(
                    'key' => $attrId,
                    'value' => $attrValue
                );
            }
        }
        //delete empty value
        foreach($result as $key => $value) {
            if(!$value['value']) {
                unset($result[$key]);
            }
        }
        return $result;
    }

    /**
     * Сохраняет атрибуты торгового предложения
     */
    private function saveAttrs()
    {
        $attributes = $this->prepareAttrSave();
        OfferHasAttribute::model()->deleteAll('offer_id = :offer_id', array('offer_id' => $this->id));
        foreach($attributes as $attrValue) {
            $OfferHasAttribute = new OfferHasAttribute();
            $OfferHasAttribute->offer_id = $this->id;
            $OfferHasAttribute->attribute_id = $attrValue['key'];
            $OfferHasAttribute->value = $attrValue['value'];
            $OfferHasAttribute->save();
        }
    }

    protected function afterSave()
    {
        parent::afterSave();
        $this->saveAttrs();
    }

    /**
     * Устанавливаем категорию оффера в критерии
     * @param $alias
     * @return $this
     */
    public function applyCategory($alias)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'with' => array(
                    'good' => array(
                        'with' => array(
                            'category' => array(
                                'condition' => 'category.alias = :calias',
                                'params' => array(':calias' => $alias),
                            )
                        )
                    )
                )
            )
        );
        return $this;
    }

    /**
     * Устанавливаем алиас оффера в критерии
     * @param $alias
     * @return $this
     */
    public function applyOffer($alias)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 't.alias = :galias',
                'params' => array(':galias' => $alias),
            )
        );
        return $this;
    }

    /**
     * Получаем набор связанных товаров
     * @return CActiveDataProvider
     */
    public function getRelationGoods()
    {
        $result = Offer::model()->published()->groupByGood();
        $criteria = new CDbCriteria();
        $criteria->compare(
            't.good_id',
            array_keys(CHtml::listData($this->good->relationGoods, 'relation_good_id', 'sort'))
        );

        return new CActiveDataProvider($result, array('criteria' => $criteria));
    }

    /**
     * Формируем массив с картинками для указанного предложения
     * @param Offer $offer
     * @return array
     */
    public function getImages($offer)
    {
        $result[] = array(
            'name'  => $offer->name,
            'image' => $offer->getImageUrl(),
            'thumb' => $offer->getImageThumbnail()
        );
        if($offer->gallery) {
            foreach ($offer->gallery->images as $image) {
                $result[] = array(
                    'name'  => $image->alt,
                    'image' => $image->getRawUrl(),
                    'thumb' => $image->getUrl(137, 130, \Imagine\Image\ImageInterface::THUMBNAIL_INSET)
                );
            }
        }
        return $result;
    }

    /**
     * Формируем массив с картинками для всех предложений связанных с оффером
     * @return array
     */
    public function getAllImages()
    {
        $result = $this->getImages($this);
        if($this->good->offers) {
            foreach($this->good->offers as $offer) {
                if($offer->id !== $this->id) {
                    $result = array_merge($result, $this->getImages($offer));
                }
            }
        }
        return $result;
    }


    public function getAllAttributes()
    {
        $result = array_merge((array)$this->offerAttributes, $this->good->goodAttributes);
        return $result;
    }
}