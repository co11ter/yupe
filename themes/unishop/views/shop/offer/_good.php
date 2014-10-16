<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 15.09.14
 * Time: 13:20
 *
 * @var $data Offer
 */
?>
<!--Tile-->
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="tile">
        <div class="price-label">
            <?php echo Yii::app()->getNumberFormatter()->formatCurrency($data->price, 'RUB');?>
        </div>
        <?php echo CHtml::link(
            CHtml::image(
                $data->getImageThumbnail(356, 390),
                $data->name
            ),
            '/shop/'.$data->good->category->alias.'/'.$data->alias
        );?>

        <?php
        /**
         * Футер товара пока закоментирован
         */
        /*<div class="footer">
            <a href="#">Nikon D5300</a>
            <span>by Pirate3d</span>

            <div class="tools">
                <div class="rate">
                    <span class="active"></span>
                    <span class="active"></span>
                    <span class="active"></span>
                    <span></span>
                    <span></span>
                </div>
                <!--Add To Cart Button-->
                <a href="#" class="add-cart-btn"><span>To cart</span><i class="icon-shopping-cart"></i></a>
                <!--Share Button-->
                <div class="share-btn">
                    <div class="hover-state">
                        <a href="#" class="fa fa-facebook-square"></a>
                        <a href="#" class="fa fa-twitter-square"></a>
                        <a href="#" class="fa fa-google-plus-square"></a>
                    </div>
                    <i class="fa fa-share"></i>
                </div>
                <!--Add To Wishlist Button-->
                <a href="#" class="wishlist-btn">
                    <div class="hover-state">Wishlist</div>
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        */?>
    </div>
</div>