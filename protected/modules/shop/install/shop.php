<?php
/**
 *
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
    ),
    'component' => array(),
    'rules'     => array(
        '/shop/<cid>/<name>' => 'shop/shop/index',
        '/shop/<cid>' => 'shop/shop/index',
        '/shop' => 'shop/shop/index'
    ),
);