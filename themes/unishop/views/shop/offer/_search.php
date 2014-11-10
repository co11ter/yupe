<?php
/**
 * @var $prices - мин и макс цены выборки
 * @var $model Offer
 * @var $attributes OfferHasAttribute
 * @var $this OfferController
 */
if($prices): ?>
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
            foreach($offerAttrs as $attr) {
                $fields = ShopHelper::makeAttributeFilterField(
                    $attr->attribute_id,
                    $attr->attribute->type_id,
                    explode(',', $attr->value),
                    'offerAttributes'
                );

                echo CHtml::tag('section', array('class' => 'filter-section'),
                    CHtml::tag('h3', array(), $attr->attribute->name).
                    CHtml::tag('span', array('class' => 'clear clearChecks'),
                        Yii::t('ShopModule.shop', 'Clear')
                    ).$fields
                );

            }
            foreach($goodAttrs as $attr) {
                $fields = ShopHelper::makeAttributeFilterField(
                    $attr->attribute_id,
                    $attr->attribute->type_id,
                    explode(',', $attr->value),
                    'goodAttributes'
                );

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
<?php endif; ?>