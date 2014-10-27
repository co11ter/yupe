<ul class="breadcrumb">
    <li>
        <?php echo CHtml::link(Yii::t('YupeModule.yupe', 'Home'), '/')?>
    </li>
</ul>

<section class="catalog-grid">
    <?php
    if (Yii::app()->hasModule('shop')) {
        Yii::app()->getModule('shop');
        $this->widget('application.modules.shop.widgets.ShopGridWidget', array(
            'template' => '<h2>'.Yii::t('ShopModule.shop', 'Items').'</h2>{items}'
        ));
    }
    ?>

</section>