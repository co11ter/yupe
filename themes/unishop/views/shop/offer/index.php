<?php
/**
 * @var $prices - мин и макс цены выборки
 * @var $model Offer
 * @var $dataProvider
 * @var $attributes OfferHasAttribute
 * @var $this OfferController
 */
$this->pageTitle = Yii::t('ShopModule.shop', 'Items');
$this->breadcrumbs = array(
    Yii::t('ShopModule.shop', 'Items')//,
    //Yii::t()
);
Yii2Debug::dump($dataProvider);

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

<section class="catalog-grid">
    <div class="container">
        <h2><?php echo Yii::t('ShopModule.shop', 'Items');?></h2>
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
                        <h3><?php echo Yii::t('ShopModule.shop', 'Price');?></h3>
                        <form id="filters" name="price-filters" method="post">
                            <span id="clearPrice" class="clear"><?php echo Yii::t('ShopModule.shop', 'Clear');?></span>
                            <?php
                            /*<div class="price-btns">
                                <button value="below 50$" class="btn btn-success btn-sm">below 50$</button><br>
                                <button value="50$-100$" class="btn btn-success btn-sm disabled">50$-100$</button><br>
                                <button value="100$-300$" class="btn btn-success btn-sm">100$-300$</button><br>
                                <button value="300$-1000$" class="btn btn-success btn-sm">300$-1000$</button>
                            </div>
                            */
                            echo CHtml::hiddenField(
                                Yii::app()->getRequest()->csrfTokenName,
                                Yii::app()->getRequest()->csrfToken
                            );
                            ?>
                            <div class="price-slider">
                                <div id="price-range"></div>
                                <div class="values group">
                                    <!--data-min-val represent minimal price and data-max-val maximum price respectively in pricing slider range; value="" - default values-->
                                    <?php
                                    echo CHtml::textField(
                                        'Offer[minPrice]',
                                        $model->minPrice ? $model->minPrice : $prices->minPrice,
                                        array(
                                            'class' => 'form-control',
                                            'data-min-val' => $prices->minPrice,
                                            'id' => 'minVal'
                                        )
                                    );
                                    echo CHtml::tag('span', array('class' => 'labels'), '&nbsp;р -&nbsp;');
                                    echo CHtml::textField(
                                        'Offer[maxPrice]',
                                        $model->maxPrice ? $model->maxPrice : $prices->maxPrice,
                                        array(
                                            'class' => 'form-control',
                                            'data-max-val' => $prices->maxPrice,
                                            'id' => 'maxVal'
                                        )
                                    );
                                    echo CHtml::tag('span', array('class' => 'labels'), '&nbsp;р');
                                    ?>
                                </div>
                                <input type="submit" value="Filter" class="btn btn-primary btn-sm">
                            </div>
                        </form>
                    </section>

                    <?php
                    foreach($attributes as $attr) {
                        $fields = '';
                        if(Attribute::TYPE_MULTIPLE_LIST == $attr->attribute->type_id) {
                            foreach(explode(',', $attr->value) as $value) {
                                $fields .= CHtml::tag('label', array(),
                                    CHtml::checkBox(
                                        'Offer[offerAttributes]['.$attr->attribute_id.'][]',
                                        array_key_exists($attr->attribute_id, $model->offerAttributes)
                                        && in_array($value, $model->offerAttributes[$attr->attribute_id]),
                                        array(
                                            'id' => 'Offer_offerAttributes_'.$attr->attribute_id,
                                            'value' => $value,
                                            'form' => 'filters'
                                        )
                                    ).$value
                                ).'<br>';
                            }
                        } elseif(Attribute::TYPE_LIST == $attr->attribute->type_id) {
                            foreach(explode(',', $attr->value) as $value) {
                                $fields .= CHtml::tag('label', array(),
                                        CHtml::radioButton(
                                            'Offer[offerAttributes]['.$attr->attribute_id.'][]',
                                            array_key_exists($attr->attribute_id, $model->offerAttributes)
                                            && in_array($value, $model->offerAttributes[$attr->attribute_id]),
                                            array(
                                                'id' => 'Offer_offerAttributes_'.$attr->attribute_id,
                                                'value' => $value,
                                                'form' => 'filters'
                                            )
                                        ).$value
                                    ).'<br>';
                            }
                        } else {
                            $fields .= CHtml::textField('Offer[offerAttributes]['.$attr->attribute_id.'][]', '',
                                array(
                                    'class' => 'form-control',
                                    'id' => 'Offer_offerAttributes_'.$attr->attribute_id,
                                    'form' => 'filters',
                                    'value' => array_key_exists($attr->attribute_id, $model->offerAttributes)
                                            ? $model->offerAttributes[$attr->attribute_id]
                                            : ''
                                )
                            );
                        }

                        echo CHtml::tag('section', array('class' => 'filter-section'),
                            CHtml::tag('h3', array(), $attr->attribute->name).
                            CHtml::tag('span', array('class' => 'clear clearChecks'),
                                Yii::t('ShopModule.shop', 'Clear')
                            ).$fields
                        );

                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
