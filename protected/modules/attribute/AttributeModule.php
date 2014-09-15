<?php
use yupe\components\WebModule;

class AttributeModule extends WebModule
{
    public function getDependencies()
    {
        return array(
            'category',
        );
    }

    public function getName()
    {
        return Yii::t('AttributeModule.attribute', 'Attribute');
    }

    public function getDescription()
    {
        return Yii::t('AttributeModule.attribute', 'Module for managing goods attribute');
    }

    public function getAuthor()
    {
        return Yii::t('AttributeModule.attribute', 'Emfy');
    }

    public function getAuthorEmail()
    {
        return Yii::t('AttributeModule.attribute', 'dev@emfy.com');
    }

    public function getUrl()
    {
        return Yii::t('AttributeModule.attribute', 'http://emfy.com');
    }

    public function getCategory()
    {
        return Yii::t('AttributeModule.attribute', 'Content');
    }

    public function getIcon()
    {
        return 'glyphicon glyphicon-flag';
    }

    public function getAdminPageLink()
    {
        return '/attribute/attributeBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('AttributeModule.attribute', 'Attribute list'), 'url' => array('/attribute/attributeBackend/index')),
            array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('AttributeModule.attribute', 'Add a attribute'), 'url' => array('/attribute/attributeBackend/create')),
        );
    }

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'attribute.models.*',
			'attribute.components.*',
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
