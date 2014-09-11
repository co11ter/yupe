<?php

/**
 * @var $model Attribute
 * @var $this AttributeBackendController
 */
$this->breadcrumbs = array(
        Yii::t('AttributeModule.attribute', 'Attribute') => array('/attribute/attributeBackend/index'),
        Yii::t('AttributeModule.attribute', 'Creating'),
    );

    $this->pageTitle = Yii::t('AttributeModule.attribute', 'Attributes - creating');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('AttributeModule.attribute', 'Attribute admin'), 'url' => array('/attribute/attributeBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('AttributeModule.attribute', 'Add a attribute'), 'url' => array('/attribute/attributeBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('AttributeModule.attribute', 'Attributes'); ?>
        <small><?php echo Yii::t('AttributeModule.attribute', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>