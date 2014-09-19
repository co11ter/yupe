<?php
/**
 * ShopBackendController контроллер для управления магазином в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.catalog.controllers
 * @since 0.1
 *
 */
class OfferBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return array(
            'inline' => array(
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Offer',
                'validAttributes' => array('name', 'alias', 'price', 'article', 'status')
            )
        );
    }
    /**
     * Отображает товар по указанному идентификатору
     * @param integer $id Идинтификатор товар для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель товара.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Offer;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Offer']))
        {
            $model->attributes = $_POST['Offer'];
            $model->attributeIds = $_POST['Offer']['offerAttributes'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.shop', 'Record was added!')
                );

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование товара.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Offer']))
        {
            $model->attributes = $_POST['Offer'];
            $model->attributeIds = $_POST['Offer']['offerAttributes'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.shop', 'Record was updated!')
                );

               if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
               else
                    $this->redirect(array($_POST['submit-type']));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Удаяет модель товара из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор товара, который нужно удалить
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('ShopModule.shop', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('ShopModule.shop', 'Unknown request. Don\'t repeat it please!'));
    }

    /**
     * Управление товарами.
     */
    public function actionIndex()
    {
        $model = new Offer('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Offer']))
            $model->attributes = $_GET['Offer'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     * @return array|CActiveRecord|mixed|null
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Offer::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('ShopModule.shop', 'Page was not found!'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param Offer $model модель, которую необходимо валидировать
     */
    protected function performAjaxValidation(Offer $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'good-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}