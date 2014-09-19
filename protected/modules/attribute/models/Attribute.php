<?php

/**
 * Created by PhpStorm.
 * User: develop
 * Date: 01.08.14
 * Time: 13:59
 */
class Attribute extends yupe\models\YModel
{
    const TYPE_BOOLEAN = 0;
    const TYPE_STRING = 1;
    const TYPE_FLOAT = 2;
    const TYPE_LIST = 3;
    const TYPE_MULTIPLE_LIST = 4;

    public $filtering = array();

    public $categoryIds = array();

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
        return '{{attribute_attribute}}';
    }

    /**
     * @return array the attribute types
     */
    public function getTypeList()
    {
        return array(
            self::TYPE_BOOLEAN => Yii::t('AttributeModule.attribute', 'Boolean'),
            self::TYPE_STRING => Yii::t('AttributeModule.attribute', 'String'),
            self::TYPE_FLOAT => Yii::t('AttributeModule.attribute', 'Float'),
            self::TYPE_LIST => Yii::t('AttributeModule.attribute', 'List'),
            self::TYPE_MULTIPLE_LIST => Yii::t('AttributeModule.attribute', 'Multiple list'),
        );
    }

    /**
     * @param $index
     * @return mixed the attribute type
     */
    public function getType($index)
    {
        $data = $this->getTypeList();
        return isset($data[$this->type_id]) ? $data[$this->type_id] : Yii::t('AttributeModule.attribute', '*unknown*');
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('category.id', $this->categoryIds, true);
        $criteria->with = array('category'=>array('select'=>'category.id','together'=>true));

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('AttributeModule.attribute', 'ID'),
            'name' => Yii::t('AttributeModule.attribute', 'Name'),
            'type_id' => Yii::t('AttributeModule.attribute', 'Type'),
            'category_id' => Yii::t('AttributeModule.attribute', 'Category'),
            'value_list' => Yii::t('AttributeModule.attribute', 'Value list'),
            'for_filter' => Yii::t('AttributeModule.attribute', 'Participates in the filtration'),
            'categoryIds' => Yii::t('AttributeModule.attribute', 'Category'),
            'filtering' => Yii::t('AttributeModule.attribute', 'Filtering'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id' => Yii::t('AttributeModule.attribute', 'ID'),
            'name' => Yii::t('AttributeModule.attribute', 'Name'),
            'type_id' => Yii::t('AttributeModule.attribute', 'Type'),
            'category_id' => Yii::t('AttributeModule.attribute', 'Category'),
            'value_list' => Yii::t('AttributeModule.attribute', 'Separate values by ​​newline'),
            'for_filter' => Yii::t('AttributeModule.attribute', 'Participates in the filtration'),
            'filtering' => Yii::t('AttributeModule.attribute', 'Filtering'),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('type_id, name', 'required', 'except' => 'search'),
            array('name', 'filter', 'filter' => 'trim'),
            array('name', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('type_id', 'numerical', 'integerOnly' => true),
            array('type_id', 'length', 'max' => 11),
            array('name', 'length', 'max' => 250),
            array('id, type_id, name, categoryIds, filtering, value_list', 'safe', 'on' => 'search'),
            array('categoryIds, filtering, value_list', 'type', 'type' => 'array'),
            array('value_list', 'filter', 'filter' => 'serialize'),
        );
    }

    public function relations()
    {
        return array(
            'category' => array(self::MANY_MANY, 'Category', '{{attribute_category_has_attribute}}(category_id, attribute_id)')
        );
    }

    public function getCategoryList()
    {
        return Category::model()->getFormattedList();
    }

    protected function beforeValidate() {
        if(isset($this->value_list)) {
            $result = array();
            $this->value_list = explode(PHP_EOL, $this->value_list);
            foreach($this->value_list as $value) {
                $result[] = trim($value);
            }
            $this->value_list = $result;
        }
        return true;
    }

    protected function afterSave()
    {
        parent::afterSave();
        if($this->categoryIds) {
            foreach($this->categoryIds as $attrId => $attrValue) {
                if($this->getIsNewRecord()) {
                    $CategoryHasAttribute = new CategoryHasAttribute();
                } else {
                    $CategoryHasAttribute = CategoryHasAttribute::model()->findByPk(array(
                        'category_id'  => $attrValue,
                        'attribute_id' => $this->id
                    ));
                }
                $CategoryHasAttribute->category_id = $attrValue;
                $CategoryHasAttribute->attribute_id = $this->id;
                $CategoryHasAttribute->save();
            }
        }
        if($this->filtering) {
            foreach($this->filtering as $attrId => $attrValue) {
                $CategoryHasAttribute = CategoryHasAttribute::model()->findByPk(array(
                    'category_id'  => $attrValue,
                    'attribute_id' => $this->id
                ));
                if($CategoryHasAttribute) {
                    $CategoryHasAttribute->for_filter = 1;
                    $CategoryHasAttribute->save();
                }
            }
        }
    }

    protected function afterFind()
    {
        if($this->category) {
            foreach($this->category as $cat) {
                $this->categoryIds[] = $cat->id;
                $CategoryHasAttribute = CategoryHasAttribute::model()->findByPk(array(
                    'category_id'  => $cat->id,
                    'attribute_id' => $this->id
                ));
                if($CategoryHasAttribute){
                    $this->filtering[] = $CategoryHasAttribute->for_filter
                        ? $CategoryHasAttribute->category_id
                        : null;
                }
            }
        }
        if($this->value_list) {
            $this->value_list = unserialize($this->value_list);
        }
    }
}