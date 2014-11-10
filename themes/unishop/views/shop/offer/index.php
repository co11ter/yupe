<?php
/**
 * @var $prices - мин и макс цены выборки
 * @var $model Offer
 * @var $dataProvider
 * @var $offerAttrs OfferHasAttribute
 * @var $goodAttrs GoodHasAttribute
 * @var $this OfferController
 */
$this->pageTitle = Yii::t('ShopModule.shop', 'Items');
$this->breadcrumbs = array(
    Yii::t('ShopModule.shop', 'Items')//,
    //Yii::t()
);

Yii::app()->clientScript->registerScript('search', "
    $('form#filters').submit(function(){
        $.fn.yiiListView.update('goodlistview', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<section class="catalog-grid">
    <div class="container">
        <h2><?php echo Yii::t('ShopModule.shop', 'Items');?></h2>
        <div class="row">
            <?php
            $this->widget('bootstrap.widgets.TbListView',array(
                'dataProvider' => $dataProvider,
                'itemView'     => '_good',
                'template'     => "{items}\n{pager}",
                'itemsCssClass'=> 'row',
                'htmlOptions'  => array(
                    'class' => 'col-lg-9 col-md-9 col-sm-8',
                    'id'    => 'goodlistview'
                )
            ));
            $this->renderPartial('_search',array(
                'model' => $model,
                'offerAttrs' => $offerAttrs,
                'goodAttrs' => $goodAttrs,
                'prices' => $prices // max и min цены
            )); ?>

        </div>
    </div>
</section>
