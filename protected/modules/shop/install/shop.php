<?php
/**
 * Файл конфигурации модуля shop
 *
 * @author co11ter <dev@emfy.com>
 * @link http://emfy.com
 * @copyright 2014 emfy
 * @package yupe.modules.shop.install
 * @license  BSD
 * @since 0.1
 *
 */
return array(
    'module'   => array(
        'class'  => 'application.modules.shop.ShopModule',
    ),
    'import'    => array(
        'application.modules.shop.models.*',
        'application.modules.shop.components.*',
    ),
    'component' => array(
        'shoppingCart' => array(
            'class' => 'application.modules.shop.components.EShoppingCart',
        ),
    ),
    'rules' => array(
        '/shop/exchange' => 'shop/exchange/unloading',
        '/shoppingcart/<action:\w+>' => 'shop/shoppingcart/<action>',
        '/shoppingcart' => 'shop/shoppingcart/index',
        '/shop/<cid>/<name>' => 'shop/offer/index',
        '/shop/<cid>' => 'shop/offer/index',
        '/shop' => 'shop/offer/index'
    ),
);