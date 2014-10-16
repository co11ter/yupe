<?php
/**
 * Страница товарного предложения
 * @var $offer - Offer Data Provider
 */
$assetUrl = Yii::app()->getTheme()->getAssetsUrl();
$this->pageTitle = $offer->name;
$this->description = $offer->good->meta_description ? : $this->description;
$this->keywords = $offer->good->meta_keywords ? : $this->keywords;

$this->breadcrumbs = array(
    Yii::t('ShopModule.shop','Items') => array('/shop/'),
    Yii::t(
        'ShopModule.shop',
        '{Category}',
        array('{Category}' => $offer->good->category->name)
    ) => array('/shop/'.$offer->good->category->alias),
    CHtml::encode($offer->name)
); ?>
<section class="cart-message">
    <i class="fa fa-check-square"></i>
    <?php
    echo CHtml::tag('p',
        array('class' => 'p-style3'),
        CHtml::encode($offer->name) . '&nbsp;' . Yii::t('ShopModule.shop', 'was successfully added to your cart')
    );
    echo CHtml::link(Yii::t('ShopModule.shop', 'View cart'),
        '/shoppingcart',
        array('class' => 'btn-outlined-invert btn-success btn-sm')
    );
    ?>
</section>
<section class="catalog-single">
    <div class="container">
        <h1><?php echo CHtml::encode($offer->name); ?></h1>
        <div class="row">

            <!--Product Gallery-->
            <div class="col-lg-6 col-md-6">
                <div id="prod-gal" class="prod-gal master-slider">
                    <?php
                    echo CHtml::tag('div', array('class' => 'ms-slide'),
                        CHtml::image(
                            $assetUrl . '/images/blank.gif',
                            $offer->name,
                            array('data-src' => $offer->getImageUrl())
                        ).
                        CHtml::image(
                            $offer->getImageThumbnail(),
                            'thumb',
                            array('class' => 'ms-thumb')
                        )
                    );
                    if($offer->gallery) {
                        foreach ($offer->gallery->images as $image) {
                            echo CHtml::tag('div', array('class' => 'ms-slide'),
                                CHtml::image(
                                    $assetUrl . '/images/blank.gif',
                                    $image->alt,
                                    array('data-src' => $image->getRawUrl())
                                ).
                                CHtml::image(
                                    $image->getUrl(137, 130),
                                    'thumb',
                                    array('class' => 'ms-thumb')
                                )
                            );
                        }
                    } ?>
                </div>
            </div>

            <!--Product Description-->
            <div class="col-lg-6 col-md-6">

                <div class="price">
                    <?php echo Yii::app()->getNumberFormatter()->formatCurrency($offer->price, 'RUB');?>
                </div>
                <div class="buttons group">
                    <input type="hidden" value="<?php echo $offer->id;?>" id="itemId">
                    <div class="qnt-count">
                        <a href="#" class="incr-btn">-</a>
                        <input type="text" value="1" class="form-control" id="quantity">
                        <a href="#" class="incr-btn">+</a>
                    </div>
                    <a href="#" id="addItemToCart" class="btn btn-primary btn-sm">
                        <i class="icon-shopping-cart"></i>
                        <?php echo Yii::t('ShopModule.shop', 'Add to cart'); ?>
                    </a>
                    <a href="#" class="btn btn-success btn-sm">
                        <i class="icon-heart"></i>
                        <?php echo Yii::t('ShopModule.shop', 'Add to wishlist'); ?>
                    </a>
                </div>
                <div>
                    <?php foreach($offer->offerAttributes as $attr) {
                        echo CHtml::tag('b', array(), CHtml::encode($attr->attribute->name)).': '.CHtml::encode($attr->value).'<br/>';
                    }?>
                </div>
                <p class="p-style2">
                    <?php echo $offer->description;?>
                </p>
            </div>
        </div>
    </div>
</section>
<section class="tabs-widget">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#reviews"><?php echo Yii::t('ShopModule.shop', 'Reviews'); ?></a></li>
        <li class=""><a data-toggle="tab" href="#related"><?php echo Yii::t('ShopModule.shop', 'Related goods'); ?></a></li>
    </ul>
    <div class="tab-content">

        <!--Tab1 (Reviews)-->
        <div id="reviews" class="tab-pane fade active in">
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

        <!--Tab2 (Related goods)-->
        <div id="related" class="tab-pane fade">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-5 col-sm-5">
                        <img alt="Description" src="img/posts-widget/2.jpg" class="center-block">
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-7">
                        <p class="p-style2">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore.</p>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                                <h4>Unordered list</h4>
                                <ul>
                                    <li>List item</li>
                                    <li><a href="#">List item link</a></li>
                                    <li>List item</li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6">
                                <h4>Ordered list</h4>
                                <ol>
                                    <li>List item</li>
                                    <li><a href="#">List item link</a></li>
                                    <li>List item</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>