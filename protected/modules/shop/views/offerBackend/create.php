<?php
    $this->breadcrumbs = array(
        Yii::t('ShopModule.shop', 'Offers') => array('/shop/offerBackend/index'),
        Yii::t('ShopModule.shop', 'Creating'),
    );

    $this->pageTitle = Yii::t('ShopModule.shop', 'Offers - creating');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.shop', 'Offer manage'), 'url' => array('/shop/offerBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.shop', 'Add a offer'), 'url' => array('/shop/offerBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.shop', 'Offers'); ?>
        <small><?php echo Yii::t('ShopModule.shop', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>