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
     * Покажем товары в указанной категории
     * @param string $cid
     */
    public function actionIndex($cid = '')
    {
        $model = new Offer('search');
        $model->unsetAttributes();

        if(isset($_POST['Offer']))
            $model->attributes=$_POST['Offer'];

        $offersProvider = $model->search();
        $offersProvider->model->published()->groupByGood();

        // категория товара
        if($cid) {
            $offersProvider->model->applyCategory($cid);
        }

        $offersProvider->getCriteria()->mergeWith(array(
            'limit' => self::GOOD_PER_PAGE,
            'order' => 't.create_time DESC',
        ));

        $this->render('index', array(
            'dataProvider' => $offersProvider,
            'model' => $model,
            'offerAttrs' => OfferHasAttribute::model()->createFilter()->findAll(),
            'goodAttrs' => GoodHasAttribute::model()->createFilter()->findAll(),
            'prices' => $model->published()->limitPrices()->find() // max и min цены
        ));
    }

    /**
     * Покажем карточку товара
     * @param $name
     * @throws CHttpException
     */
    public function actionView($name)
    {
        $model = Offer::model()->published()->applyOffer($name)->find();

        if ($model === null)
            throw new CHttpException(404, Yii::t('ShopModule.shop', 'Page was not found!'));
        $this->render('good', array('model' => $model));
    }

    protected function beforeAction()
    {
        Yii::app()->getModule('attribute');
        Yii::app()->getModule('gallery');
        return true;
    }
}