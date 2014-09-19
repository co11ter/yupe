<?php
    $this->breadcrumbs = array(        
        Yii::t('ShopModule.shop', 'Offers') => array('/shop/offerBackend/index'),
        $model->name => array('/shop/offerBackend/view', 'id' => $model->id),
        Yii::t('ShopModule.shop', 'Edition'),
    );

    $this->pageTitle = Yii::t('ShopModule.shop', 'Offers - edition');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.shop', 'Offers administration'), 'url' => array('/shop/offerBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.shop', 'Add a product'), 'url' => array('/shop/offerBackend/create')),
        array('label' => Yii::t('ShopModule.shop', 'Product') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('ShopModule.shop', 'Update product'), 'url' => array(
            '/shop/offerBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.shop', 'Show product'), 'url' => array(
            '/shop/offerBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('ShopModule.shop', 'Remove product'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/shop/offerBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('ShopModule.shop', 'Do you really want to remove product?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.shop', 'Update product'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>