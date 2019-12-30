<?php

namespace app\controllers;

use app\components\CrudControllerInterface;
use app\components\CrudControllerTrait;
use app\components\customWidgets\CustomCaptchaAction;
use app\components\Setting;
use app\models\ContactForm;
use app\models\Request;
use app\components\AuthController;
use Yii;
use yii\swiftmailer\Mailer;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * RequestController implements the CRUD actions for Slide model.
 */
class RequestController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait; // add crud functions [index, create, update, delete]

    public $defaultAction = 'new';

    /**
     * @inheritDoc
     */
    public static function getModelName()
    {
        return Request::className();
    }

    public function getSystemActions()
    {
        return array_merge(parent::getSystemActions(), [
            'new',
            'captcha'
        ]);
    }

    public function getMenuActions()
    {
        return [
            'new'
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => CustomCaptchaAction::className(),
                'setTheme' => true,
                'width' => 130,
                'height' => 40,
                'transparent' => true,
                'onlyNumber' => true,
                'foreColor' => 0x555555,
                'minLength' => 4,
                'maxLength' => 4,
                'fontFile' => '@webroot/themes/frontend/assets/fonts/OpenSans-Bold.ttf'
            ],
        ];
    }

    /**
     * Displays a single Slide model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        /** @var Request $model */
        $model = $this->findModel($id);
        if ($model->status == Request::STATUS_UNREAD) {
            $model->status = Request::STATUS_PENDING;
            $model->save();
        }
        if(is_null($model->user_lang)){
            $model->user_lang = 'ar';
            $model->save();
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Slide model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (app()->request->isAjax and !app()->request->isPjax) {
            $model->load(app()->request->post());
            app()->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (app()->request->post()) {
            $model->load(app()->request->post());
            if ($model->save()) {
                app()->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(app()->request->post('return') == 'view' ? ['view', 'id' => $model->id] : ['index']);
            } else
                app()->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionNew()
    {
        $this->setTheme('frontend');
        $this->innerPage = true;
        
        $this->bodyClass = 'more-one list';
        $this->mainTag = 'main-submit-page';

        $model = new Request();
        $model->setScenario('new');

        if (app()->request->isAjax and !app()->request->isPjax) {
            $model->load(app()->request->post());
            app()->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (app()->request->post()) {
            $model->load(app()->request->post());
            if ($model->save()) {
                if (Setting::get('request_email')) {
                    Yii::$app->mailer->compose('layouts/request_mail', ['model' => $model])
                        ->setTo(Setting::get('request_email'))
                        ->setFrom(['noreply@rezvan.info' => $model->name])
                        ->setSubject('درخواست جدید')
                        ->send();
                }

                app()->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->refresh();
            } else
                app()->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('new', [
            'model' => $model,
        ]);
    }
}
