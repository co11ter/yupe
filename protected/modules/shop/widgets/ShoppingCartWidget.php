<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 16.09.14
 * Time: 19:03
 */

class ShoppingCartWidget extends yupe\widgets\YWidget
{
    public $view = 'shoppingcartwidget';

    public function run()
    {
        $data = array();

        // Если не подрубить данный файл, то будет ошибка десериализации
        Yii::import('zii.behaviors.CTimestampBehavior');

        $positions = Yii::app()->shoppingCart->getPositions();
        foreach($positions as $position) {
            $data[] = array(
                'id'        => $position->id,
                'name'      => $position->name,
                'quantity'  => $position->getQuantity(),
                'price'     => $position->getSumPrice()
            );
        }

        $this->render(
            $this->view,
            array(
                'cart' => array(
                    'data' => $data,
                    'count' => Yii::app()->shoppingCart->getItemsCount(),
                    'cost' => Yii::app()->shoppingCart->getCost(),
                    'currency' => Yii::t('ShopModule.shop', 'RUB')
                )
            )
        );
    }
}