<?php

/**
 * Модель Good
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
 * This is the model class for table "good".
 *
 * The followings are the available columns in table 'good':
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property double $price
 * @property string $article
 * @property string $image
 * @property string $short_description
 * @property string $description
 * @property string $alias
 * @property string $data
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $user_id
 * @property string $change_user_id
 *
 * The followings are the available model relations:
 * @property User $changeUser
 * @property Category $category
 * @property User $user
 */
class Good extends yupe\models\YModel
{
    const SPECIAL_NOT_ACTIVE = 0;
    const SPECIAL_ACTIVE     = 1;

    const STATUS_ZERO       = 0;
    const STATUS_ACTIVE     = 1;
    const STATUS_NOT_ACTIVE = 2;

    public $attributeIds = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Good the static model class
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
        return '{{shop_good}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('category_id, name, description, alias', 'required', 'except' => 'search'),
            array('name, description, short_description, image, alias, price, article, data, status, is_special', 'filter', 'filter' => 'trim'),
            array('name, alias, price, article, data, status, is_special', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('status, category_id, is_special, user_id', 'numerical', 'integerOnly' => true),
            array('status, category_id, is_special, user_id', 'length', 'max' => 11),
            array('price', 'numerical'),
            array('name, image', 'length', 'max' => 250),
            array('article', 'length', 'max' => 100),
            array('alias', 'length', 'max' => 150),
            array('status','in','range' => array_keys($this->statusList)),
            array('is_special','in','range' => array(0, 1)),
            array('alias', 'yupe\components\validators\YSLugValidator', 'message' => Yii::t('ShopModule.shop', 'Illegal characters in {attribute}')),
            array('alias', 'unique'),
            array('id, category_id, name, price, article, short_description, description, alias, data, status, create_time, update_time, user_id, change_user_id, is_special, goodAttributes', 'safe', 'on' => 'search'),
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
            'changeUser' => array(self::BELONGS_TO, 'User', 'change_user_id'),
            'category'   => array(self::BELONGS_TO, 'Category', 'category_id'),
            'user'       => array(self::BELONGS_TO, 'User', 'user_id'),
            'goodAttributes'  => array(self::HAS_MANY, 'GoodHasAttribute', 'good_id'),
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
            'category_id'       => Yii::t('ShopModule.shop', 'Category'),
            'name'              => Yii::t('ShopModule.shop', 'Name'),
            'price'             => Yii::t('ShopModule.shop', 'Price'),
            'article'           => Yii::t('ShopModule.shop', 'Article'),
            'image'             => Yii::t('ShopModule.shop', 'Image'),
            'short_description' => Yii::t('ShopModule.shop', 'Short description'),
            'description'       => Yii::t('ShopModule.shop', 'Description'),
            'alias'             => Yii::t('ShopModule.shop', 'Alias'),
            'data'              => Yii::t('ShopModule.shop', 'Data'),
            'status'            => Yii::t('ShopModule.shop', 'Status'),
            'create_time'       => Yii::t('ShopModule.shop', 'Added'),
            'update_time'       => Yii::t('ShopModule.shop', 'Updated'),
            'user_id'           => Yii::t('ShopModule.shop', 'User'),
            'change_user_id'    => Yii::t('ShopModule.shop', 'Editor'),
            'is_special'        => Yii::t('ShopModule.shop', 'On home page'),
            'goodAttributes'    => Yii::t('ShopModule.shop', 'Attribute'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'                => Yii::t('ShopModule.shop', 'ID'),
            'category_id'       => Yii::t('ShopModule.shop', 'Category'),
            'name'              => Yii::t('ShopModule.shop', 'Name'),
            'price'             => Yii::t('ShopModule.shop', 'Price'),
            'article'           => Yii::t('ShopModule.shop', 'Article'),
            'image'             => Yii::t('ShopModule.shop', 'Image'),
            'short_description' => Yii::t('ShopModule.shop', 'Short description'),
            'description'       => Yii::t('ShopModule.shop', 'Description'),
            'alias'             => Yii::t('ShopModule.shop', 'Alias'),
            'data'              => Yii::t('ShopModule.shop', 'Data'),
            'status'            => Yii::t('ShopModule.shop', 'Status'),
            'create_time'       => Yii::t('ShopModule.shop', 'Added'),
            'update_time'       => Yii::t('ShopModule.shop', 'Edited'),
            'user_id'           => Yii::t('ShopModule.shop', 'User'),
            'change_user_id'    => Yii::t('ShopModule.shop', 'Editor'),
            'is_special'        => Yii::t('ShopModule.shop', 'On home page'),
            'goodAttributes'    => Yii::t('ShopModule.shop', 'Attribute'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($cid = '', $name = '')
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, false);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('article', $this->article, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('is_special', $this->is_special, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('user_id', $this->user_id,true);
        $criteria->compare('change_user_id', $this->change_user_id, true);

        foreach($this->goodAttributes as $id => $value) {
            if($value) {
                $criteria->mergeWith(array(
                    'join'=>'JOIN '.GoodHasAttribute::model()->tableName().' attr'.$id.' ON attr'.$id.'.good_id = t.id'
                ));
                $criteria->compare('attr'.$id.'.attribute_id', $id, false);
                $criteria->compare('attr'.$id.'.value', $value, true);
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

    public function getSpecial()
    {
        $data = $this->getSpecialList();
        return isset($data[$this->is_special]) ? $data[$this->is_special] : Yii::t('ShopModule.shop', '*unknown*');
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
                \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND
            );
        }

        return false;
    }

    /**
     * category link
     *
     * @return string html caregory link
     **/
    public function getCategoryLink()
    {
        return $this->category instanceof Category
            ? CHtml::link($this->category->name, array("/category/default/view", "id" => $this->category_id))
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

    protected function afterSave()
    {
        parent::afterSave();
        $attributes = $this->prepareAttrSave();
        GoodHasAttribute::model()->deleteAll('good_id = :good_id', array('good_id' => $this->id));
        foreach($attributes as $attrValue) {
            $GoodHasAttribute = new GoodHasAttribute();
            $GoodHasAttribute->good_id = $this->id;
            $GoodHasAttribute->attribute_id = $attrValue['key'];
            $GoodHasAttribute->value = $attrValue['value'];
            $GoodHasAttribute->save();
        }
    }

    public function applyCategory($alias)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'with' => array(
                    'category' => array(
                        'condition' => 'category.alias = :alias',
                        'params' => array(':alias' => $alias),
                    )
                )
            )
        );
    }

    public function applyGood($alias)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 't.alias = :alias',
                'params' => array(':alias' => $alias),
            )
        );
    }
}