<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 18.09.14
 * Time: 16:41
 *
 * The followings are the available columns in table 'good':
 *
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property string $article
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $short_description
 * @property string $description
 * @property string $alias
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $user_id
 * @property string $change_user_id
 * @property string $external_id
 */

class Good extends yupe\models\YModel
{
    const STATUS_ACTIVE     = 1;
    const STATUS_NOT_ACTIVE = 0;

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
        return '{{shop_good}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, category_id, description, alias', 'required', 'except' => 'search'),
            array('external_id', 'unique'),
            array('status, category_id, user_id, change_user_id', 'numerical', 'integerOnly' => true),
            array('status, category_id, user_id, change_user_id', 'length', 'max' => 11),
            array('name', 'length', 'max' => 250),
            array('article', 'length', 'max' => 100),
            array('alias', 'length', 'max' => 150),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array(
                'alias',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('ShopModule.shop', 'Illegal characters in {attribute}')
            ),
            array(
                'name, meta_description, meta_keywords, description, short_description, meta_description, meta_keywords',
                'filter',
                'filter' => 'trim'
            ),
            array(
                'name, alias, article, status, meta_description, meta_keywords',
                'filter',
                'filter' => array($obj = new CHtmlPurifier(), 'purify')
            ),
            array(
                'id, name, meta_description, meta_keywords, external_id, category_id, alias, short_description, description, article, status, create_time, update_time, user_id, change_user_id',
                'safe',
                'on' => 'search'
            )
        );
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute'   => 'create_time',
                'updateAttribute'   => 'update_time',
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
            'meta_description'  => Yii::t('ShopModule.shop', 'Description(Meta)'),
            'meta_keywords'     => Yii::t('ShopModule.shop', 'Keywords(Meta)'),
            'article'           => Yii::t('ShopModule.shop', 'Article'),
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
            'meta_description'  => Yii::t('ShopModule.shop', 'Description(Meta)'),
            'meta_keywords'     => Yii::t('ShopModule.shop', 'Keywords(Meta)'),
            'article'           => Yii::t('ShopModule.shop', 'Article'),
        );
    }

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, false);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('article', $this->article, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
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

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE     => Yii::t('ShopModule.shop', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('ShopModule.shop', 'Not active'),
        );
    }
} 