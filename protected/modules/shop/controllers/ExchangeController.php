<?php
/**
 * ExchangeController - контроллер для осуществления обмена данными с 1С
 * Created by PhpStorm.
 * User: develop
 * Date: 19.09.14
 * Time: 14:02
 */

class ExchangeController extends yupe\components\controllers\FrontController
{
    public function actionUnloading($key)
    {
        if($key != Yii::app()->getModule('shop')->exchangeKey) {
            Yii::app()->end('Wrong secret key!');
        }

        if(!in_array(Yii::app()->request->userHostAddress, Yii::app()->getModule('shop')->exchangeIps)) {
            Yii::app()->end('Wrong host ip!');
        }

        Import1c::processRequest(Yii::app()->request->getQuery('type'), Yii::app()->request->getQuery('mode'));
    }
} 