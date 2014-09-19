<?php

/**
 * @var $model Good
 * @var $this CatalogBackendController
 */
$this->breadcrumbs = array(
        Yii::t('ShopModule.shop', 'Offers') => array('/shop/offerBackend/index'),
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

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="glyphicon glyphicon-search">&nbsp;</i>
        <?php echo Yii::t('ShopModule.catalog', 'Find products'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('good-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
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
            ['/shop/offerBackend/create'],
            ['class' => 'btn btn-success pull-right btn-sm']
        )
    ],
    'columns'      => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->id, array("/shop/shopBackend/update", "id" => $data->id))'
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
            'name'  => 'alias',
            'editable' => array(
                'url' => $this->createUrl('/shop/offerBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            ),
            'filter'   => CHtml::activeTextField($model, 'alias', array('class' => 'form-control')),
        ),
        array(
            'class'  => 'bootstrap.widgets.TbEditableColumn',
			'editable' => array(
				'url'    => $this->createUrl('/shop/offerBackend/inline'),
				'mode'   => 'popup',
				'type'   => 'select',
				'title'  => Yii::t(
                        'ShopModule.shop',
                        'Select {field}',
                        array('{field}' => mb_strtolower($model->getAttributeLabel('category_id')))
                    ),
				'source' => Category::model()->getFormattedList(Yii::app()->getModule('shop')->mainCategory),
				'params' => array(
					Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
				)
			),
            'name'   => 'category_id',
            'type'   => 'raw',
            'value'  => '$data->category->name',
            'filter' => CHtml::activeDropDownList(
                    $model,
                    'category_id',
                    Category::model()->getFormattedList(Yii::app()->getModule('shop')->mainCategory),
                    array('encode' => false, 'empty' => '', 'class' => 'form-control'))
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'price',
            'editable' => array(
                'url' => $this->createUrl('/shop/offerBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            ),
            'filter'   => CHtml::activeTextField($model, 'price', array('class' => 'form-control')),
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'article',
            'editable' => array(
                'url' => $this->createUrl('/shop/offerBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            ),
            'filter'   => CHtml::activeTextField($model, 'article', array('class' => 'form-control')),
        ),

        array(
            'name'  => 'is_special',
            'type'  => 'raw',
            'value'  => '$data->is_special',
            'filter' => Yii::app()->getModule('shop')->getChoice()
        ),
        array(
            'class'  => 'bootstrap.widgets.TbEditableColumn',
			'editable' => array(
				'url'    => $this->createUrl('/shop/offerBackend/inline'),
				'mode'   => 'popup',
				'type'   => 'select',
				'title'  => Yii::t(
                        'ShopModule.shop',
                        'Select {field}',
                        array('{field}' => mb_strtolower($model->getAttributeLabel('status')))
                    ),
				'source' => $model->getStatusList(),
				'params' => array(
					Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
				)
			),
            'name'   => 'status',
            'type'   => 'raw',
            'value'  => '$data->getStatus()',
            'filter' => CHtml::activeDropDownList(
                    $model,
                    'status',
                    $model->getStatusList(),
                    array('class' => 'form-control', 'empty' => '')
                ),
        ),
        array(
            'name'   => 'user_id',
            'type'   => 'raw',
            'value'  => 'CHtml::link($data->user->getFullName(), array("/user/userBackend/view", "id" => $data->user->id))',
            'filter' => CHtml::listData(
                    User::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll(),
                    'id',
                    'nick_name'
                )
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>