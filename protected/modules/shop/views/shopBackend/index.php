<?php

/**
 * @var $model Good
 * @var $this CatalogBackendController
 */
$this->breadcrumbs = array(
        Yii::t('ShopModule.shop', 'Offers') => array('/shop/shopBackend/index'),
        Yii::t('ShopModule.shop', 'Manage'),
    );

    $this->pageTitle = Yii::t('ShopModule.shop', 'Manage products');

    $this->menu = array(
        array('label' => Yii::t('ShopModule.shop', 'Shop'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.shop', 'Good manage'), 'url' => array('/shop/shopBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.shop', 'Add a good'), 'url' => array('/shop/shopBackend/create')),
        )),
        array('label' => Yii::t('ShopModule.shop', 'Offers'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.shop', 'Offer manage'), 'url' => array('/shop/offerBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.shop', 'Add a offer'), 'url' => array('/shop/offerBackend/create')),
        )),
        array('label' => Yii::t('ShopModule.shop', 'Attribute'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.shop', 'Attribute list'), 'url' => array('/attribute/attributeBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.shop', 'Add a attribute'), 'url' => array('/attribute/attributeBackend/create')),
        ))
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.shop', 'Items'); ?>
        <small><?php echo Yii::t('ShopModule.shop', 'administration'); ?></small>
    </h1>
</div>

<br/>

<p><?php echo Yii::t('ShopModule.shop', 'This section describes products manager'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'good-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'actionsButtons' => [
        CHtml::link(
            Yii::t('YupeModule.yupe', 'Add'),
            ['/shop/shopBackend/create'],
            ['class' => 'btn btn-success pull-right btn-sm']
        )
    ],
    'columns'      => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->id, array("/shop/offerBackend/update", "id" => $data->id))'
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'name',
            'editable' => array(
                'url' => $this->createUrl('/shop/shopBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            ),
            'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'meta_description',
            'editable' => array(
                'url' => $this->createUrl('/shop/shopBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            ),
            'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'meta_keywords',
            'editable' => array(
                'url' => $this->createUrl('/shop/shopBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            ),
            'filter'   => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>