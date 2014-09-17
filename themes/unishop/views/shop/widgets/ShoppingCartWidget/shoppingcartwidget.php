<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 16.09.14
 * Time: 19:09
 *
 * @var $cart - array from /shop/shoppingcart/index
 */
?>
<?php echo CHtml::link(
    '<i class="icon-shopping-cart-content"></i>'.CHtml::tag('span', array(), $cart['count']),
    '/shoppingcart',
    array(
        'class' => 'btn btn-outlined-invert'
    )
);?>
<div class="cart-dropdown">
    <span></span><!--Small rectangle to overlap Cart button-->
    <div class="body">
        <?php
        $h3 = '';
        $body = '';

        // Заголовок таблицы
        $header = CHtml::tag('tr', array(),
            CHtml::tag('th', array(), Yii::t('ShopModule.shop', 'Items')) .
            CHtml::tag('th', array(), Yii::t('ShopModule.shop', 'Quantity')) .
            CHtml::tag('th', array(), Yii::t('ShopModule.shop', 'Price'))
        );

        // Перебираем элементы
        foreach ($cart['data'] as $item) {
            $body .= CHtml::tag('tr', array('class' => 'item'),
                CHtml::hiddenField('itemIdCart', $item['id'], array('id' => 'itemIdCart')).
                CHtml::tag('td', array(), '<div class="delete"></div>' . CHtml::link($item['name'], '#')) .
                CHtml::tag('td', array(), CHtml::textField('', $item['quantity'])) .
                CHtml::tag('td', array('class' => 'price'), $item['price'] . '&nbsp;' . Yii::t('ShopModule.shop', 'RUB'))
            );
        }

        // Сообщение о пустой корзине
        $h3 = CHtml::tag('h3', array('class' => $cart['data'] ? 'hidden' : ''), Yii::t('ShopModule.shop', 'Cart is empty!'));

        echo CHtml::tag('table', array('class' => $cart['data'] ? '' : 'hidden'),
            CHtml::tag('tbody', array(), $h3 . $header . $body)
        );
        ?>
    </div>
    <div class="footer group">
        <div class="buttons">
            <?php echo CHtml::link(
                '<i class="icon-download"></i>'.Yii::t('ShopModule.shop', 'Checkout'),
                '/shoppingcart/clear',
                array(
                    'class' => 'btn btn-outlined-invert',
                    'id' => 'clearCart'
                )
            );?>
            <?php echo CHtml::link(
                '<i class="icon-shopping-cart-content"></i>'.Yii::t('ShopModule.shop', 'To cart'),
                '/shoppingcart',
                array(
                    'class' => 'btn btn-outlined-invert'
                )
            );?>
        </div>
        <?php echo CHtml::tag('div', array('class' => 'total'), $cart['cost'].'&nbsp;'.Yii::t('ShopModule.shop', 'RUB'));?>
    </div>
</div>