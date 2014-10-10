<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 09.10.14
 * Time: 17:15
 */

class AttributeValue extends yupe\models\YModel
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
        return '{{attribute_value}}';
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('type_id', $this->type_id, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'        => Yii::t('AttributeModule.attribute', 'ID'),
            'name'      => Yii::t('AttributeModule.attribute', 'Category'),
            'type_id'   => Yii::t('AttributeModule.attribute', 'Participates in the filtration'),
            'value'     => Yii::t('AttributeModule.attribute', 'Participates in the filtration'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'        => Yii::t('AttributeModule.attribute', 'ID'),
            'name'      => Yii::t('AttributeModule.attribute', 'Attribute'),
            'type_id'   => Yii::t('AttributeModule.attribute', 'Type'),
            'value'     => Yii::t('AttributeModule.attribute', 'Value'),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, value', 'required', 'except' => 'search'),
            array('id, type_id', 'numerical', 'integerOnly' => true),
            array('id, type_id', 'length', 'max' => 11),
            array('id, name, type_id, value', 'safe', 'on' => 'search'),
        );
    }
}