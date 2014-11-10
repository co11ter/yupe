<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 07.11.14
 * Time: 15:08
 */
class ShopHelper {

    public static function makeAttributeFilterField($id, $type, $data, $field) {
        $result = '';
        if(Attribute::TYPE_MULTIPLE_LIST == $type) {
            foreach($data as $value) {
                $result .= CHtml::tag('label', array(),
                        CHtml::checkBox(
                            'Offer['.$field.']['.$id.'][]',
                            false,
                            array(
                                'id' => 'Offer_'.$field.'_'.$id,
                                'value' => $value,
                                'form' => 'filters'
                            )
                        ).$value
                    ).'<br>';
            }
        } elseif(Attribute::TYPE_LIST == $type) {
            foreach($data as $value) {
                $result .= CHtml::tag('label', array(),
                        CHtml::radioButton(
                            'Offer['.$field.']['.$id.']',
                            false,
                            array(
                                'id' => 'Offer_'.$field.'_'.$id,
                                'value' => $value,
                                'form' => 'filters'
                            )
                        ).$value
                    ).'<br>';
            }
        } else {
            $result .= CHtml::textField('Offer['.$field.']['.$id.']', '',
                array(
                    'class' => 'form-control',
                    'id' => 'Offer_'.$field.'_'.$id,
                    'form' => 'filters',
                    'value' => ''
                )
            );
        }
        return $result;
    }
}