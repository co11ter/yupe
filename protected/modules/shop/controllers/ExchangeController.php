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
    private $secretKey = '11';

    private $ip = '';

    public function actionUnloading()
    {
        if(Yii::app()->getRequest()->getPost('file'))
        {
//            $transaction = Yii::app()->db->beginTransaction();
//            $transaction->commit();
//            $transaction->rollback();
        }
    }

    public function actionIndex()
    {

    }

    protected function beforeAction()
    {
        $key = Yii::app()->getRequest()->getQuery('k');
        if($key === $this->secretKey) {
            return true;
        }
        return false;
    }
} 