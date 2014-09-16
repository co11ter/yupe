<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 15.09.14
 * Time: 20:08
 */
return array(
    'module'   => array(
        'class'  => 'application.modules.shoppingcart.ShoppingCartModule',
    ),
    'import'    => array(
        'application.modules.shoppingcart.components.*',
    ),
    'component' => array(
        'shoppingCart' => array(
            'class' => 'application.modules.shoppingcart.components.EShoppingCart'
        )
    ),
    'rules'     => array(),
);