<?php

namespace app\controllers;

use app\components\Setting;
use Yii;
use app\models\Donation;
use app\models\DonationSearch;
use app\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\components\CrudControllerTrait;
use app\components\CrudControllerInterface;

/**
 * DonationController implements the CRUD actions for Donation model.
 */
class DonationController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait;

    /**
    * @return string
    */
    public function getModelName()
    {
        return Donation::className();
    }

    public function getViewPath()
    {
        return '@app/views/layouts/default_crud';
    }

    public function actionSetting()
    {
        $this->setTheme("default", ['bodyClass' => 'innerPages']);

        if (\Yii::$app->request->post()) {
            $postData = \Yii::$app->request->post('Setting');
//dd($postData);
            ## region validation post data
            $config = Setting::getAll();
            ## endregion validation post data

            Setting::createOrUpdateDefaults($config);
            $postData['map']['enabled'] = (bool)isset($postData['map']['enabled']);

            foreach ($config as $key => $value) {
                if (!isset($postData[$key]))
                    continue;
                if (is_array($config[$key]) && is_array($postData[$key])) {
                    foreach ($config[$key] as $subKey => $subVal) {
                        if (!isset($postData[$key][$subKey]))
                            continue;
                        if ($subVal != $postData[$key][$subKey])
                            $config[$key][$subKey] = $postData[$key][$subKey];
                    }
                } elseif ($postData[$key] && $value != $postData[$key])
                    $config[$key] = $postData[$key];
            }

            if (Setting::setAll($config)) {
                \Yii::$app->session->setFlash('alert',
                        ['type' => 'success', 'message' => \trans('words', 'base.successMsg')]);
                return $this->refresh();
            }
            else
                \Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => \trans('words', 'base.dangerMsg')]);
        }
        $settings = Setting::getAll(true);

        return $this->render('/donation/setting', compact('settings'));
    }
}
