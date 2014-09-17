<?php
/**
 * Created by PhpStorm.
 * User: develop
 * Date: 16.09.14
 * Time: 16:03
 */

class ShoppingcartController extends yupe\components\controllers\FrontController
{
    public function actionIndex()
    {
        $cart = $this->getCart();
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            echo CJSON::encode($cart);
            Yii::app()->end();
        } else {
            $this->render('index', array('cart' => $cart));
        }

    }

    /**
     * "Положим" товар в корзину
     * @var $id - id модели Good
     * @var $quantity - кол-во товара
     * @throws CHttpException
     */
    public function actionPut()
    {
        if($id = (int)Yii::app()->getRequest()->getPost('id')) {
            $model = $this->loadModel($id);
            $quantity = (int)Yii::app()->getRequest()->getPost('quantity',1);
            Yii::app()->shoppingCart->put(
                $model,
                $quantity
            );
            echo CJSON::encode($this->getCart());
            Yii::app()->end();
        } else {
            throw new CHttpException(400, Yii::t('ShopModule.shop', 'Unknown request. Don\'t repeat it please!'));
        }
    }

    /**
     * Очистка корзины
     */
    public function actionClear()
    {
        Yii::app()->shoppingCart->clear();
        echo CJSON::encode($this->getCart());
        Yii::app()->end();
    }

    public function actionDelete()
    {
        if($id = (int)Yii::app()->getRequest()->getPost('id')) {
            Yii::app()->shoppingCart->remove($id);
            echo CJSON::encode($this->getCart());
            Yii::app()->end();
        } else {
            throw new CHttpException(400, Yii::t('ShopModule.shop', 'Unknown request. Don\'t repeat it please!'));
        }
    }

    /**
     * Получаем товары в корзине
     * @param bool $full - если true, то вернет массив товаров с фото и ценой
     * @return array
     */
    protected function getCart($full = false) {
        $data = array();

        $positions = Yii::app()->shoppingCart->getPositions();
        foreach($positions as $position) {
            $data[] = array(
                'id'        => $position->id,
                'name'      => $position->name,
                'itemPrice' => $position->price,
                'totalPrice'=> $position->getSumPrice(),
                'quantity'  => $position->getQuantity(),
                'photo'     => $position->getImageThumbnail(152, 119),
                'url'       => $position->getUrl()
            );
        }
        return array(
            'data'  => $data,
            'count' => Yii::app()->shoppingCart->getItemsCount(),
            'cost' => Yii::app()->shoppingCart->getCost(),
            'currency' => Yii::t('ShopModule.shop', 'RUB')
        );
    }

    protected  function loadModel($id)
    {
        $model = Good::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('ShopModule.shop', 'Page was not found!'));
        return $model;
    }

    protected function beforeAction()
    {
        // Если не подрубить данный файл, то будет ошибка десериализации
        Yii::import('zii.behaviors.CTimestampBehavior');
        return true;
    }
}