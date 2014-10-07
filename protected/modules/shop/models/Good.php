<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 18.09.14
 * Time: 16:41
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
            array('name', 'required', 'except' => 'search'),
            array('name, meta_description, meta_keywords', 'filter', 'filter' => 'trim'),
            array('id, name, meta_description, meta_keywords', 'safe', 'on' => 'search')
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

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function getOffersAttributes()
    {

    }
} 