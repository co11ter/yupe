<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 17.09.14
 * Time: 15:40
 *
 * @var $cart - array
 */

$this->pageTitle = Yii::t('ShopModule.shop', 'Shopping cart');
$this->breadcrumbs = array(Yii::t('ShopModule.shop', 'Shopping cart'));
?>

<section class="shopping-cart">
    <div class="container">
        <div class="row">

            <!--Items List-->
            <div class="col-lg-9 col-md-9">
                <?php
                echo CHtml::tag(
                    'h2',
                    array(
                        'class' => 'title'.($cart['data'] ? ' hidden' : ''),
                        'id' => 'h2CartEmpty'
                    ),
                    Yii::t('ShopModule.shop', 'Cart is empty!')
                );
                echo CHtml::tag(
                    'h2',
                    array(
                        'class' => 'title'.($cart['data'] ? '' : ' hidden'),
                        'id' => 'h2CartFull'
                    ),
                    Yii::t('ShopModule.shop', 'Shopping cart')
                );

                // Заголовок таблицы
                $header = CHtml::tag('tr', array(),
                    CHtml::tag('th', array(), '&nbsp;') .
                    CHtml::tag('th', array(), Yii::t('ShopModule.shop', 'Product name')) .
                    CHtml::tag('th', array(), Yii::t('ShopModule.shop', 'Product price')).
                    CHtml::tag('th', array(), Yii::t('ShopModule.shop', 'Quantity')).
                    CHtml::tag('th', array(), Yii::t('ShopModule.shop', 'Total'))
                );

                // Перебираем элементы
                $body = '';
                foreach ($cart['data'] as $item) {
                    $body .= CHtml::tag('tr', array('class' => 'item'),

                        // скрытое поле с id товара
                        CHtml::hiddenField('itemIdCart', $item['id'], array('class' => 'itemIdCart')).

                        // фото с линкой на товар
                        CHtml::tag('td', array('class' => 'thumb'),
                            CHtml::link(
                                CHtml::image($item['photo'], $item['name']),
                                $item['url']
                            )
                        ) .

                        // название товара
                        CHtml::tag('td', array('class' => 'name'),
                            CHtml::link($item['name'], $item['url'])
                        ) .

                        // цена одного товара
                        CHtml::tag('td', array('class' => 'price'),
                            $item['itemPrice'] . '&nbsp;' . $cart['currency']
                        ) .

                        // количество
                        CHtml::tag('td', array('class' => 'qnt-count'),
                            CHtml::link('-', '#', array('class' => 'incr-btn incr-submit')).
                            CHtml::textField('', $item['quantity'], array('class' => 'quantity form-control')).
                            CHtml::link('+', '#', array('class' => 'incr-btn incr-submit'))
                        ) .

                        // цена с учетом количества
                        CHtml::tag('td', array('class' => 'total'),
                            $item['totalPrice'] . '&nbsp;' . $cart['currency']
                        ) .

                        // иконка удаления
                        CHtml::tag('td', array('class' => 'delete'),
                            CHtml::tag('i', array('class' => 'icon-delete'))
                        )
                    );
                }

                echo CHtml::tag('table', array('class' => 'items-list'.($cart['data'] ? '' : ' hidden')),
                    CHtml::tag('tbody', array(), $header . $body)
                );
                ?>
            </div>

            <!--Sidebar-->
            <div class="col-lg-3 col-md-3">
                <?php echo CHtml::tag('h3', array(), Yii::t('ShopModule.shop', 'Cart totals')); ?>
                <div class="cart-sidebar">
                    <div class="cart-totals">
                        <table>
                            <tbody>
                            <?php
                            echo CHtml::tag('tr', array(),
                                CHtml::tag('td', array(),
                                    Yii::t('ShopModule.shop', 'Cart subtotal')
                                ) .
                                CHtml::tag('td', array('class' => 'total align-r'),
                                    $cart['cost'] . '&nbsp;' . $cart['currency']
                                )
                            );
                            echo CHtml::tag('tr', array('class' => 'devider'),
                                CHtml::tag('td', array(),
                                    Yii::t('ShopModule.shop', 'Shipping')
                                ) .
                                CHtml::tag('td', array('class' => 'align-r'),
                                    Yii::t('ShopModule.shop', 'Free shipping')
                                )
                            );
                            echo CHtml::tag('tr', array(),
                                CHtml::tag('td', array(),
                                    Yii::t('ShopModule.shop', 'Order total')
                                ) .
                                CHtml::tag('td', array('class' => 'total align-r'),
                                    $cart['cost'] . '&nbsp;' . $cart['currency']
                                )
                            );
                            ?>
                            </tbody>
                        </table>

                        <input type="submit" value="<?php echo Yii::t('ShopModule.shop', 'Checkout')?>" name="delete-cart" class="btn btn-primary btn-sm btn-block">
                        <input type="submit" value="<?php echo Yii::t('ShopModule.shop', 'Proceed to checkout')?>" name="to-checkout" class="btn btn-success btn-block">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>