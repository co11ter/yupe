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
    private $secretKey = 'd41d8cd98f00b204e9800998ecf8427e';

    private $ip = array('192.168.5.29', '192.168.5.123');

    public function actionUnloading($key)
    {
        if($key != $this->secretKey) {
            Yii::app()->end('Wrong secret key!');
        }

        if(!in_array(Yii::app()->request->userHostAddress, $this->ip)) {
            Yii::app()->end('Wrong host ip!');
        }

        Import1c::processRequest(Yii::app()->request->getQuery('type'), Yii::app()->request->getQuery('mode'));
    }
} 