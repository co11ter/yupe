<?php
use yupe\components\WebModule;

class ShopModule extends WebModule
{
    const VERSION = '0.1';

    public $uploadPath        = 'shop';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize           = 0;
    public $maxSize           = 5242880;
    public $maxFiles          = 1;

    public function getDependencies()
    {
        return array(
            'category',
            'attribute',
        );
    }

    public function getName()
    {
        return Yii::t('ShopModule.shop', 'Shop');
    }

    public function getDescription()
    {
        return Yii::t('ShopModule.shop', 'Module for managing shop');
    }

    public function getAuthor()
    {
        return Yii::t('ShopModule.shop', 'Emfy');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ShopModule.shop', 'dev@emfy.com');
    }

    public function getUrl()
    {
        return Yii::t('ShopModule.shop', 'http://emfy.com');
    }

    public function getCategory()
    {
        return Yii::t('ShopModule.shop', 'Content');
    }

    public function getIcon()
    {
        return 'glyphicon glyphicon-shopping-cart';
    }

    public function getAdminPageLink()
    {
        return '/shop/shopBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('ShopModule.shop', 'Products')),
            array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('ShopModule.shop', 'Shop manage'), 'url' => array('/shop/shopBackend/index')),
            array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('ShopModule.shop', 'Add a product'), 'url' => array('/shop/shopBackend/create')),
            array('label' => Yii::t('ShopModule.shop', 'Attribute')),
            array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('ShopModule.shop', 'Attribute list'), 'url' => array('/attribute/attributeBackend/index')),
            array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('ShopModule.shop', 'Add a attribute'), 'url' => array('/attribute/attributeBackend/create')),
        );
    }
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'shop.models.*',
			'shop.components.*',
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
