<?php

namespace app\controllers;

use app\components\customWidgets\CustomCaptchaAction;
use app\components\gateway\GatewayInterface;
use app\components\gateway\PayPingGateway;
use app\components\MainController;
use app\components\SmsSender;
use app\models\Donation;
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
        $this->setTheme('frontend', ['layout' => 'inner']);

        $model = new PaymentForm();

        if (request()->post()) {
            $model->load(request()->post());
            $model->filled = true;

            if ($model->validate()) {
                $invoiceNumber = time();
                app()->session->set('payment_amount', $model->amount);
                app()->session->set('invoice_id', $invoiceNumber);

                $donate = new Donation();
                $donate->name = $model->payerName;
                $donate->mobile = $model->payerMobile;
                $donate->amount = $model->amount;
                $donate->invoice_id = $invoiceNumber;
                if ($donate->save()) {
                    app()->session->set('donate_id', $donate->id);
                }


                /** @var GatewayInterface|PayPingGateway $gateway */
                $gateway = app()->gateway;

                $returnUrl = Url::to('/payment/verify', true);
                $gateway->setPayArguments(
                        $model->amount,
                        $model->payerName,
                        $model->description,
                        $returnUrl,
                        $invoiceNumber);

                if ($gateway->pay()) {
                    $this->redirect($gateway->payUrl());
                } else {
                    dd($gateway->errorMessage());
                }
            }
        }

        return $this->render('index', compact('model'));
    }

    public function actionVerify()
    {
        $this->setTheme('frontend', ['layout' => 'inner']);

        $model = new PaymentForm();

        /** @var GatewayInterface|PayPingGateway $gateway */
        $gateway = app()->gateway;
        if ($gateway->verify(app()->session->get('payment_amount'))) {
            $donate = Donation::findOne(app()->session->get('donate_id'));
            if ($donate) {
                $donate->status = Donation::STATUS_PAID;
                $donate->save();
            }

            app()->session->setFlash('alert',
                    ['type' => 'success', 'message' => trans('words', 'Thanks! Payment was successful.')]);
//            SmsSender::Send()
        } else {
            app()->session->setFlash('alert', [
                    'type' => 'danger',
                    'message' => trans('words', 'Oops! Unsuccessful payment, There is a problem.')
            ]);
        }

        return $this->redirect(['index']);
    }
}
