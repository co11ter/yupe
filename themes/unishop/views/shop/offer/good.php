<?php
/**
 * Страница товарного предложения
 * @var Offer $model
 */
$assetUrl = Yii::app()->getTheme()->getAssetsUrl();
$this->pageTitle = $model->name;
$this->description = $model->good->meta_description ? : $this->description;
$this->keywords = $model->good->meta_keywords ? : $this->keywords;

$this->breadcrumbs = array(
    Yii::t('ShopModule.shop','Items') => array('/shop/'),
    Yii::t(
        'ShopModule.shop',
        '{Category}',
        array('{Category}' => $model->good->category->name)
    ) => array('/shop/'.$model->good->category->alias),
    CHtml::encode($model->name)
); ?>
<section class="cart-message">
    <i class="fa fa-check-square"></i>
    <?php
    echo CHtml::tag('p',
        array('class' => 'p-style3'),
        CHtml::encode($model->name) . '&nbsp;' . Yii::t('ShopModule.shop', 'was successfully added to your cart')
    );
    echo CHtml::link(Yii::t('ShopModule.shop', 'View cart'),
        '/shoppingcart',
        array('class' => 'btn-outlined-invert btn-success btn-sm')
    );
    ?>
</section>
<section class="catalog-single">
    <div class="container">
        <h1><?php echo CHtml::encode($model->name); ?></h1>
        <div class="row">

            <!--Product Gallery-->
            <div class="col-lg-6 col-md-6">
                <div id="prod-gal" class="prod-gal master-slider">
                    <?php
                    foreach ($model->getAllImages() as $image) {
                        echo CHtml::tag('div', array('class' => 'ms-slide'),
                            CHtml::image(
                                $assetUrl . '/images/blank.gif',
                                $image['name'],
                                array('data-src' => $image['image'])
                            ).
                            CHtml::image(
                                $image['thumb'],
                                'thumb',
                                array('class' => 'ms-thumb')
                            )
                        );
                    } ?>
                </div>
            </div>

            <!--Product Description-->
            <div class="col-lg-6 col-md-6">

                <div>
                    <?php
                    foreach($model->good->offers as $offer)
                    {
                        $option = $model->id===$offer->id ? array('class' => 'active') : array();
                        echo CHtml::link($offer->name, '/shop/'.$model->good->category->alias.'/'.$offer->alias, $option).'<br/>';
                    } ?>
                    <br/>
                </div>
                <div class="price">
                    <?php echo Yii::app()->getNumberFormatter()->formatCurrency($model->price, 'RUB');?>
                </div>
                <div class="buttons group">
                    <input type="hidden" value="<?php echo $model->id;?>" id="itemId">
                    <div class="qnt-count">
                        <a href="#" class="incr-btn">-</a>
                        <input type="text" value="1" class="form-control" id="quantity">
                        <a href="#" class="incr-btn">+</a>
                    </div>
                    <a href="#" id="addItemToCart" class="btn btn-primary btn-sm">
                        <i class="icon-shopping-cart"></i>
                        <?php echo Yii::t('ShopModule.shop', 'Add to cart'); ?>
                    </a>
                </div>
                <?php echo CHtml::tag('div', array(), $model->description) ?>
                <?php echo CHtml::tag('div', array(), $model->good->description) ?>
                <div>
                    <table class="items table table-striped table-bordered table-condensed">

                        <tbody>
                            <?php
                            $i = 0;
                            foreach($model->getAllAtributes() as $attr) {
                                $i++;
                                $class = $i | 1 ? 'odd' : 'even';
                                echo CHtml::tag(
                                    'tr',
                                    array(),
                                    CHtml::tag('td', array(), CHtml::encode($attr->attribute->name)).
                                    CHtml::tag('td', array(), CHtml::encode($attr->value))
                                );
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="tabs-widget">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#related"><?php echo Yii::t('ShopModule.shop', 'Related goods'); ?></a></li>
        <li><a data-toggle="tab" href="#reviews"><?php echo Yii::t('ShopModule.shop', 'Reviews'); ?></a></li>
    </ul>
    <div class="tab-content">

        <!--Tab1 (Related goods)-->
        <div id="related" class="tab-pane fade active in">
            <section class="catalog-grid">
            <?php
                $this->widget('application.modules.shop.widgets.ShopGridWidget', array(
                    'dataProvider' => $model->getRelationGoods(),
                ));
            ?>
            </section>
        </div>

        <!--Tab2 (Reviews)-->
        <div id="reviews" class="tab-pane fade">
            <div class="container">
                <div class="row">
                    <!--Disqus Comments Plugin-->
                    <div class="col-lg-10 col-lg-offset-1">
                        <div id="disqus_thread"></div>
                        <script type="text/javascript">
                            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                            var disqus_shortname = '8guild'; // required: replace example with your forum shortname

                            /* * * DON'T EDIT BELOW THIS LINE * * */
                            (function() {
                                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the &lt;a href="http://disqus.com/?ref_noscript"&gt;comments powered by Disqus.&lt;/a&gt;</noscript>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>