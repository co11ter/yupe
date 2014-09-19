<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 15.09.14
 * Time: 13:04
 *
 * @var $model - Offer
 */
?>

    <?php $this->widget('bootstrap.widgets.TbListView',array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_good',
        'template'     => '<h2>'.Yii::t('ShopModule.shop', 'Items').'</h2>{items}',
        'itemsCssClass'=> 'row',
        'htmlOptions'  => array(
            'class' => 'container'
        )
    )); ?>
