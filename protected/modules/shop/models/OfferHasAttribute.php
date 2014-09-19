<?php
/**
 * Created by PhpStorm.
 * User: Poltoratskiy A,
 * Date: 05.08.14
 * Time: 17:53
 */
class OfferHasAttribute extends yupe\models\YModel
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
        return '{{shop_offer_has_attribute}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('offer_id, attribute_id, value', 'required', 'except' => 'search'),
            array('offer_id, attribute_id', 'numerical', 'integerOnly' => true),
            array('offer_id, attribute_id', 'length', 'max' => 11),
            array('value', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('id, offer_id, attribute_id, value', 'safe', 'on' => 'search'),
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
            'offer' => array(self::BELONGS_TO, 'Offer', 'offer_id'),
            'attribute' => array(self::BELONGS_TO, 'Attribute', 'attribute_id'),
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

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('blog_id', $this->blog_id);
        $criteria->compare('value', $this->value);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function scopes()
    {
        return array(
            'createFilter' => array(
                'select' => array('offer_id', 'attribute_id', new CDbExpression('GROUP_CONCAT(value) as value')),
                'group' => 'attribute_id'
            ),
        );
    }
}