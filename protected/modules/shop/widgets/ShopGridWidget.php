<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 15.09.14
 * Time: 11:39
 */
Yii::import('application.modules.shop.models.*');

class ShopGridWidget extends yupe\widgets\YWidget
{
    public $view = 'shopgridwidget';

    public $dataProvider = '';

    public function run()
    {
        // По умолчанию те товары, которые для главной страницы
        if(!$this->dataProvider) {
            $this->dataProvider = new CActiveDataProvider(Good::model()->published()->onHomePage());
        }
        $this->render($this->view, array('dataProvider' => $this->dataProvider));
    }
}