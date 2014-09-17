<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 16.09.14
 * Time: 19:09
 *
 * @var $cart - array from /shop/shoppingcart/index
 */
Yii::app()->clientScript->registerScript('updateCartWidget', "
    function updateCartWidget(cart) {
        if(cart.data.length){
            $('.cart-dropdown h3').addClass('hidden');
            $('.cart-dropdown table').removeClass('hidden');
        } else {
            $('.cart-dropdown table').addClass('hidden');
            $('.cart-dropdown h3').removeClass('hidden');
        }

        $('.cart-btn a span').text(cart.count);
        $('.cart-dropdown div.total').text(cart.cost + ' ' + cart.currency);
        $('.cart-dropdown tr.item').remove();
        for(var i = 0; cart.data.length>i; i++) {
            $('.cart-dropdown table').append(
                '<tr class=\"item\"><input type=\"hidden\" name=\"itemIdCart\" value=\"' + cart.data[i].id + '\" class=\"itemIdCart\">' +
                '<td><div class=\"delete\"></div><a href=\"' + cart.data[i].url +'\">' +
                cart.data[i].name + '<td><input type=\"text\" value=\"' + cart.data[i].quantity +
                '\"></td><td class=\"price\">' + cart.data[i].totalPrice + '&nbsp;' +  cart.currency + '</td>'
            );
        }
    }
", CClientScript::POS_BEGIN);

echo CHtml::link(
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
                CHtml::hiddenField('itemIdCart', $item['id'], array('class' => 'itemIdCart')).
                CHtml::tag('td', array(), '<div class="delete"></div>' . CHtml::link($item['name'], '#')) .
                CHtml::tag('td', array(), CHtml::textField('', $item['quantity'])) .
                CHtml::tag('td', array('class' => 'price'), $item['totalPrice'] . '&nbsp;' . Yii::t('ShopModule.shop', 'RUB'))
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