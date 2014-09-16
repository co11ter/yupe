<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 15.09.14
 * Time: 20:08
 */
use yupe\components\WebModule;

class ShoppingCartModule extends WebModule
{
    const VERSION = '0.1';

    public function getName()
    {
        return Yii::t('ShoppingCartModule.shoppingcart', 'Shopping Cart');
    }

    public function getDescription()
    {
        return Yii::t('ShoppingCartModule.shoppingcart', 'Module for shopping cart');
    }

    public function getAuthor()
    {
        return Yii::t('ShoppingCartModule.shoppingcart', 'Emfy');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ShoppingCartModule.shoppingcart', 'dev@emfy.com');
    }

    public function getUrl()
    {
        return Yii::t('ShoppingCartModule.shoppingcart', 'http://emfy.com');
    }

    public function getCategory()
    {
        return Yii::t('ShoppingCartModule.shoppingcart', 'Services');
    }

    public function getIcon()
    {
        return 'glyphicon glyphicon-shopping-cart';
    }

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'shoppingcart.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}