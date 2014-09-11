<?php
    $this->breadcrumbs = array(       
        Yii::t('ShopModule.shop', 'Products') => array('/shop/shopBackend/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('ShopModule.shop', 'Products - view');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.shop', 'Products administration'), 'url' => array('/shop/shopBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.shop', 'Add product'), 'url' => array('/shop/shopBackend/create')),
        array('label' => Yii::t('ShopModule.shop', 'Product') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('ShopModule.shop', 'Update product'), 'url' => array(
            '/shop/shopBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.shop', 'Show product'), 'url' => array(
            '/shop/shopBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('ShopModule.shop', 'Delete product'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/shop/shopBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('ShopModule.shop', 'Do you really want to remove product?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.shop', 'Product show'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'category_id',
            'value' => $model->category->name,
        ),
        'name',
        'price',
        'article',
        'image',
        array(
            'name' => 'short_description',
            'type' => 'raw'
        ),
        array(
            'name' => 'description',
            'type' => 'raw'
        ),
        'alias',
        array(
            'name' => 'data',
            'type' => 'raw'
        ),
        array(
            'name'  => 'is_special',
            'value' => $model->getSpecial(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        array(
            'name'  => 'user_id',
            'value' => $model->user->getFullName(),
        ),
        array(
            'name'  => 'change_user_id',
            'value' => $model->changeUser->getFullName(),
        ),
        array(
            'name'  => 'create_time',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time, "short", "short"),
        ),
        array(
            'name'  => 'update_time',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time, "short", "short"),
        ),
    ),
)); ?>
