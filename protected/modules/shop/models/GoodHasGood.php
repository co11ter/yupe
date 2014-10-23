<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 10.10.14
 * Time: 15:52
 */

class GoodHasGood extends yupe\models\YModel
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_good_has_good}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('good_id, relation_good_id', 'required', 'except' => 'search'),
            array('good_id, relation_good_id, sort', 'numerical', 'integerOnly' => true),
            array('good_id, relation_good_id', 'length', 'max' => 11),
            array('sort', 'length', 'max' => 3),
            array('good_id, relation_good_id, sort', 'safe', 'on' => 'search'),
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
            'root' => array(self::BELONGS_TO, 'Good', 'good_id'),
            'good' => array(self::BELONGS_TO, 'Good', 'relation_good_id'),
        );
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

        $criteria->compare('good_id', $this->good_id);
        $criteria->compare('relation_good_id', $this->attribute_id);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }
}