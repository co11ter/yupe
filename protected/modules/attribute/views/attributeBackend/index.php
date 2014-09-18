<?php

/**
 * @var $model Attribute
 * @var $this AttributeBackendController
 */
$this->breadcrumbs = array(
        Yii::t('AttributeModule.attribute', 'Attribute') => array('/attribute/attributeBackend/index'),
        Yii::t('AttributeModule.attribute', 'Manage'),
    );

    $this->pageTitle = Yii::t('AttributeModule.attribute', 'Attribute admin');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('AttributeModule.attribute', 'Attribute admin'), 'url' => array('/attribute/attributeBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('AttributeModule.attribute', 'Add a attribute'), 'url' => array('/attribute/attributeBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('AttributeModule.attribute', 'Attributes'); ?>
        <small><?php echo Yii::t('AttributeModule.attribute', 'administration'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('AttributeModule.attribute', 'Find attributes'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('attribute-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('AttributeModule.attribute', 'This section describes attributes manager'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'attribute-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->id, array("/attribute/attributeBackend/update", "id" => $data->id))'
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'name',
            'editable' => array(
                'url' => $this->createUrl('/attribute/attributeBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            ),
            'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
        ),
        array(
            'name'   => 'type_id',
            'value'  => '$data->getType($data->type_id)',
            'filter' => $model->getTypeList()
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));?>