<?php

class AttributeBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return array(
            'inline' => array(
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Attribute',
                'validAttributes' => array('name', 'type_id')
            )
        );
    }

    /**
     * Отображает атрибут по указанному идентификатору
     * @param integer $id идинтификатор
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Управление атрибутами.
     */
    public function actionIndex()
    {
        $model = new Attribute('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Attribute']))
            $model->attributes = $_GET['Attribute'];

        $this->render('index', array('model' => $model));
    }

    /**
     * Создает новую модель аттрибута.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Attribute;
        if (isset($_POST['Attribute']))
        {
            $model->attributes = $_POST['Attribute'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('AttributeModule.attribute', 'Record was added!')
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
     * Редактирование атрибута.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Attribute']))
        {
            $model->attributes = $_POST['Attribute'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('AttributeModule.attribute', 'Record was updated!')
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
     * @param $id - идентификатор атрибута
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
                Yii::t('AttributeModule.attribute', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('AttributeModule.attribute', 'Unknown request. Don\'t repeat it please!'));
    }

    public function actionGetAttributes()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new Attribute('search');
            $model->unsetAttributes(); // clear any default values

            if (isset($_GET['Attribute']))
                $model->attributes = $_GET['Attribute'];

            if(in_array(Yii::app()->getRequest()->getParam('type'), array_keys($model->scopes())))
                $model->{Yii::app()->getRequest()->getParam('type')}();

            $output = array();
            $data = $model->search()->getData();
            // Если просто CJSON::encode, то ключ value_list будет отсутствовать.
            // Не нашел другого простого способа.
            foreach($data as $model) {
                $output[] = array(
                    'id' => $model->id,
                    'name' => $model->name,
                    'type_id' => $model->type_id,
                    'value_list' => $model->value_list
                );
            }
            Yii::app()->end(CJSON::encode($output));
        }
    }

    /**
     * Возвращает модель по указанному идентификатору
     * @param $id - идентификатор модели
     * @return array|CActiveRecord|mixed|null
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Attribute::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('AttributeModule.attribute', 'Page was not found!'));
        return $model;
    }

    /**
     * Ajax валидация
     * @param Attribute $model
     */
    protected function performAjaxValidation(Attribute $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'attribute-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}