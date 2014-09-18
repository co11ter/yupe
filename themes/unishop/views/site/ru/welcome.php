<ul class="breadcrumb">
    <li>
        <?php echo CHtml::link(Yii::t('YupeModule.yupe', 'Home'), '/')?>
    </li>
</ul>

<section class="catalog-grid">
    <?php $this->widget('application.modules.shop.widgets.ShopGridWidget'); ?>
</section>