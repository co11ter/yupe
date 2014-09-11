<?php

/**
 * @var $model Attribute
 * @var $this AttributeBackendController
 */
    $this->breadcrumbs = array(       
        Yii::t('AttributeModule.attribute', 'Attribute') => array('/attribute/attributeBackend/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('AttributeModule.attribute', 'Attributes - view');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('AttributeModule.attribute', 'Attribute admin'), 'url' => array('/attribute/attributeBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('AttributeModule.attribute', 'Add a attribute'), 'url' => array('/attribute/attributeBackend/create')),
        array('label' => Yii::t('AttributeModule.attribute', 'Attribute') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('AttributeModule.attribute', 'Update attribute'), 'url' => array(
            '/attribute/attributeBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('AttributeModule.attribute', 'Show attribute'), 'url' => array(
            '/attribute/attributeBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('AttributeModule.attribute', 'Remove attribute'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/attribute/attributeBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('AttributeModule.attribute', 'Do you really want to remove product?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('AttributeModule.attribute', 'Attribute show');?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'name',
        array(
            'name'  => 'type_id',
            'value' => $model->getType($model->type_id),
        ),
    ),
)); ?>
