<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 02.10.14
 * Time: 16:53
 */
class Import1c extends CComponent
{
    public static function processRequest($type, $mode)
    {
        $method='command'.ucfirst($type).ucfirst($mode);
        $import=new self;
        if(method_exists($import, $method))
            $import->$method();
    }

    public function commandCatalogCheckauth()
    {
        echo 'success'.PHP_EOL;
        echo Yii::app()->session->sessionName.PHP_EOL;
        echo Yii::app()->session->sessionId.PHP_EOL;
    }
}