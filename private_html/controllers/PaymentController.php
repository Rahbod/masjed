<?php

namespace app\controllers;

use app\components\customWidgets\CustomCaptchaAction;
use app\components\gateway\GatewayInterface;
use app\components\gateway\PayPingGateway;
use app\components\MainController;
use app\models\PaymentForm;
use yii\helpers\Url;

class PaymentController extends MainController
{
    public function actions()
    {
        return [
                'captcha' => [
                        'class' => CustomCaptchaAction::className(),
                        'width' => 130,
                        'height' => 40,
                ]
        ];
    }

    public function actionIndex()
    {
        $model = new PaymentForm();

        if (request()->post()) {
            $model->load(request()->post());

            if ($model->validate()) {
                app()->session->set('payment_amount', $model->amount);

                /** @var GatewayInterface|PayPingGateway $gateway */
                $gateway = app()->gateway;

                $invoiceNumber = time();
                $returnUrl = Url::to('/payment/verify', true);
                $gateway->setPayArguments(
                        $model->amount,
                        $model->payerName,
                        $model->description,
                        $returnUrl,
                        $invoiceNumber);

                if ($gateway->pay()) {
                    $this->redirect($gateway->payUrl());
                }else
                    dd($gateway->errorMessage());
            }
        }

        return $this->render('index', compact('model'));
    }

    public function actionVerify()
    {
        /** @var GatewayInterface|PayPingGateway $gateway */
        $gateway = app()->gateway;
        $gateway->verify(app()->session->get('payment_amount'));

        dd($gateway->verifyResponse);

        return $this->render('verify', compact('gateway'));
    }
}
