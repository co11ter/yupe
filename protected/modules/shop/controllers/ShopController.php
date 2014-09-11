<?php
/**
 * ShopController контроллер для вывода каталога товаров в публичной части сайта
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.shop.controllers
 * @since 0.1
 *
 */
class ShopController extends yupe\components\controllers\FrontController
{
    const GOOD_PER_PAGE = 10;

    /**
     * TODO вынести критерии в модель
     *
     * @param string $cid
     * @param string $name
     * @throws CHttpException
     */
    public function actionIndex($cid = '', $name = '')
    {
        Yii::app()->getModule('attribute');
        $attrs = GoodHasAttribute::model()->createFilter()->findAll();

        $model = new Good('search');
        $model->unsetAttributes();

        if(isset($_GET['Good']))
            $model->attributes=$_GET['Good'];

        $goodsProvider = $model->published()->search();

        $goodsProvider->getCriteria()->mergeWith(array(
            'limit' => self::GOOD_PER_PAGE,
            'order' => 't.create_time DESC',
        ));

        if($cid) {
            $goodsProvider->getCriteria()->mergeWith(
                array(
                    'with' => array(
                        'category' => array(
                            'condition' => 'category.alias = :alias',
                            'params' => array(':alias' => $cid),
                        )
                    )
                )
            );
        }
        if($name) {
            $goodsProvider->getCriteria()->mergeWith(
                array(
                    'condition' => 't.alias = :alias',
                    'params' => array(':alias' => $name),
                )
            );
        }

        $this->render('index', array(
            'dataProvider' => $goodsProvider,
            'model' => $model,
            'attributes' => $attrs
        ));
    }
}