<?php
/**
 * @var $model Good
 * @var $dataProvider
 * @var $attributes GoodHasAttribute
 * @var $this ShopController
 */
$this->pageTitle = Yii::t('ShopModule.shop', 'Products');
$this->breadcrumbs = array(Yii::t('ShopModule.shop', 'Products'));

Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $.fn.yiiListView.update('goodlistview', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<!--<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php /*echo CHtml::link(Yii::t('ShopModule.shop', 'Find products'), '#', array('class' => 'search-button')); */ ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
    <?php /*$this->renderPartial('_search', array('model' => $model, 'attributes' => $attributes)); */ ?>
</div>-->
<section class="catalog-grid">
    <div class="container">
        <h2 class="primary-color">Товары</h2>
        <?php $this->widget('application.modules.shop.widgets.ShopGridWidget', array(
            'dataProvider' => $dataProvider
        ));?>
    </div>
</section>
