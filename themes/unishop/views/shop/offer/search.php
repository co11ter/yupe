<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.shop','Items') => array('/shop/'),
    Yii::t('ShopModule.shop','Search') => array('/shop/search'),
);
?>

<section class="catalog-grid">
    <?php
    if (Yii::app()->hasModule('shop')) {
        Yii::app()->getModule('shop');
        $this->widget('application.modules.shop.widgets.ShopGridWidget', array(
            'template' => '<h2>'.Yii::t('ShopModule.shop', 'Items').'</h2>{items}',
            'dataProvider' => $dataProvider
        ));
    }
    ?>

</section>