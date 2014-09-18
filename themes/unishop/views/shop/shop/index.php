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
        <h2><?php echo Yii::t('ShopModule.shop', 'Products');?></h2>
        <div class="row">
            <?php $this->widget('bootstrap.widgets.TbListView',array(
                'dataProvider' => $dataProvider,
                'itemView'     => '_good',
                'template'     => '{items}',
                'itemsCssClass'=> 'row',
                'htmlOptions'  => array(
                    'class' => 'col-lg-9 col-md-9 col-sm-8'
                )
            )); ?>
            <div class="filters-mobile col-lg-3 col-md-3 col-sm-4">
                <div class="shop-filters">

                    <!--Price Section-->
                    <section class="filter-section">
                        <h3>Filter by price</h3>
                        <form name="price-filters" method="get">
                            <span id="clearPrice" class="clear">Clear price</span>
                            <div class="price-btns">
                                <button value="below 50$" class="btn btn-success btn-sm">below 50$</button><br>
                                <button value="50$-100$" class="btn btn-success btn-sm disabled">50$-100$</button><br>
                                <button value="100$-300$" class="btn btn-success btn-sm">100$-300$</button><br>
                                <button value="300$-1000$" class="btn btn-success btn-sm">300$-1000$</button>
                            </div>
                            <div class="price-slider">
                                <div id="price-range"></div>
                                <div class="values group">
                                    <!--data-min-val represent minimal price and data-max-val maximum price respectively in pricing slider range; value="" - default values-->
                                    <input type="text" value="180" data-min-val="10" id="minVal" name="minVal" class="form-control">
                                    <span class="labels">$ - </span>
                                    <input type="text" value="1400" data-max-val="2500" id="maxVal" name="maxVal" class="form-control">
                                    <span class="labels">$</span>
                                </div>
                                <input type="submit" value="Filter" class="btn btn-primary btn-sm">
                            </div>
                        </form>
                    </section>

                    <!--Colors Section-->
                    <section class="filter-section">
                        <h3>Filter by color</h3>
                        <span class="clear clearChecks">Clear colors</span>
                        <label>
                            <input type="checkbox" checked id="color_0" value="black" name="colors">
                            Black (12)</label>
                        <br>
                        <label>
                            <input type="checkbox" id="color_1" value="white" name="colors">
                            White (1)</label>
                        <br>
                        <label>
                            <input type="checkbox" id="color_2" value="green" name="colors">
                            Green  (34)</label>
                        <br>
                    </section>

                    <!--Colors Section-->
                    <section class="filter-section">
                        <h3>Filter by size</h3>
                        <span class="clear clearChecks">Clear size</span>
                        <label>
                            <input type="checkbox" checked id="size_0" value="small" name="sizes">
                            Small (12)</label>
                        <br>
                        <label>
                            <input type="checkbox" id="size_1" value="white" name="sizes">
                            Medium (34)</label>
                        <br>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
