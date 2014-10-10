<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 01.08.14
 * Time: 13:59
 */
class AttributeHasValue extends yupe\models\YModel
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
        return '{{attribute_attribute_has_value}}';
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

        $criteria->compare('attribute_id', $this->attribute_id, true);
        $criteria->compare('value_id', $this->value_id, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'attribute_id'  => Yii::t('AttributeModule.attribute', 'Attribute'),
            'value_id'   => Yii::t('AttributeModule.attribute', 'Value'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'attribute_id'  => Yii::t('AttributeModule.attribute', 'Attribute'),
            'value_id'   => Yii::t('AttributeModule.attribute', 'Value'),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('attribute_id, value_id', 'required', 'except' => 'search'),
            array('attribute_id, value_id', 'numerical', 'integerOnly' => true),
            array('attribute_id, value_id', 'length', 'max' => 11),
            array('attribute_id, value_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'value' => array(self::BELONGS_TO, 'AttributeValue', 'value_id'),
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attribute_id'),
        );
    }
}