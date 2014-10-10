<?php
    $this->breadcrumbs = array(
        Yii::t('ShopModule.shop', 'Offers') => array('/shop/offerBackend/index'),
        Yii::t('ShopModule.shop', 'Creating'),
    );

    $this->pageTitle = Yii::t('ShopModule.shop', 'Offers - creating');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.shop', 'Good manage'), 'url' => array('/shop/shopBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.shop', 'Add a good'), 'url' => array('/shop/shopBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.shop', 'Items'); ?>
        <small><?php echo Yii::t('ShopModule.shop', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>