<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 01.08.14
 * Time: 13:59
 */
class CategoryHasAttribute extends yupe\models\YModel
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Blog the static model class
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
        return '{{attribute_category_has_attribute}}';
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('attribute_id', $this->attribute_id, true);
        $criteria->compare('for_filter', $this->for_filter, true);
        $criteria->compare('categoryList', $this->categoryList, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'attribute_id'  => Yii::t('AttributeModule.attribute', 'ID'),
            'category_id'   => Yii::t('AttributeModule.attribute', 'Category'),
            'for_filter'    => Yii::t('AttributeModule.attribute', 'Participates in the filtration'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'attribute_id'  => Yii::t('AttributeModule.attribute', 'ID'),
            'category_id'   => Yii::t('AttributeModule.attribute', 'Category'),
            'for_filter'    => Yii::t('AttributeModule.attribute', 'Participates in the filtration'),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('attribute_id, category_id', 'required', 'except' => 'search'),
            array('attribute_id, category_id, for_filter', 'numerical', 'integerOnly' => true),
            array('attribute_id, category_id', 'length', 'max' => 11),
            array('for_filter', 'length', 'max' => 1),
            array('attribute_id, category_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attribute_id'),
        );
    }

    public function getCategoryName()
    {
        return ($this->category === null) ? '---' : $this->category->name;
    }
}