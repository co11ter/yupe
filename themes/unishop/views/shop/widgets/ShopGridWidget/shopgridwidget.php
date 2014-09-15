<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 15.09.14
 * Time: 13:04
 *
 * @var $model - Good
 */
?>

<div class="row">
    <?php $this->widget('bootstrap.widgets.TbListView',array(
        'dataProvider' => $dataProvider,
        'itemView'     => '_good',
        'template'     => "{items}\n",
    )); ?>
</div>