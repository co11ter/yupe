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
class OfferController extends yupe\components\controllers\FrontController
{
    const GOOD_PER_PAGE = 10;

    /**
     * TODO вынести критерии в модель
     *
     * @param string $cid
     * @param string $name
     * @throws CHttpException
     * @return bool
     */
    public function actionIndex($cid = '', $name = '')
    {
        Yii::app()->getModule('attribute');
        Yii::app()->getModule('gallery');
        $attrs = OfferHasAttribute::model()->createFilter()->findAll();

        $model = new Offer('search');
        $model->unsetAttributes();

        if(isset($_POST['Offer']))
            $model->attributes=$_POST['Offer'];

        $offersProvider = $model->published()->search();

        $offersProvider->getCriteria()->mergeWith(array(
            'with' => array('gallery'),
            'limit' => self::GOOD_PER_PAGE,
            'order' => 't.create_time DESC',
        ));

        // категория товара
        if($cid) {
            $offersProvider->model->applyCategory($cid);
        }

        // алиас товара
        if($name) {
            $offersProvider->model->applyOffer($name);

            // Если ищем по алиасу, то выводим страницу для одного товара
            $this->render('good', array(
                'offer' => reset($offersProvider->getData())
            ));
            return true;
        }

        $this->render('index', array(
            'dataProvider' => $offersProvider,
            'model' => $model,
            'attributes' => $attrs,
            'prices' => $model->published()->limitPrices()->find() // max и min цены
        ));
        return true;
    }
}