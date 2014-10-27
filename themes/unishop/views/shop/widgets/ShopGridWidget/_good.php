<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 15.09.14
 * Time: 13:20
 *
 * @var $data - Offer
 */
?>
<!--Tile-->
<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="tile">
        <div class="price-label">
            <?php echo Yii::app()->getNumberFormatter()->formatCurrency($data->price, 'RUB'); ?>
        </div>
        <?php echo CHtml::link(
            CHtml::image(
                $data->getImageThumbnail(356, 390),
                $data->name
            ),
            '/shop/'.$data->good->category->alias.'/'.$data->alias
        );?>

        <div class="footer">
            <?php echo CHtml::link(
                $data->name,
                '/shop/'.$data->good->category->alias.'/'.$data->alias
            );?>
        </div>
    </div>
</div>