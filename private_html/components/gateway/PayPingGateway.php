<?php


namespace app\components\gateway;


use PayPing\Payment;
use yii\base\Component;

class PayPingGateway extends Component implements GatewayInterface
{
    /**
     * @var string
     */
    public $token = "";

    /**
     * @var string
     */
    private $url;
    /**
     * @var \Exception|bool
     */
    private $error = false;
    /**
     * @var array
     */
    private $payArguments = [];
    /**
     * @var array
     */
    public $verifyResponse;

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function pay()
    {
        if (!$this->payArguments) {
            throw new \Exception("Please set payment arguments with \"paymentArguments\" function.");
        }

        $payment = new Payment($this->token);

        try {
            $payment->pay($this->payArguments);
            $this->url = $payment->getPayUrl();
            return $this->url;
        } catch (\Exception $e) {
            $this->error = $e;
            return false;
        }
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function verify($amount)
    {
        $refID = request()->get('refid');
        if (!$refID) {
            throw new \Exception("Ref ID is invalid.");
        }

        $payment = new Payment($this->token);

        try {
            if ($this->verifyResponse = $payment->verify($refID, $amount)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $this->error = $e;
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function errorMessage()
    {
        return $this->error ? $this->error->getMessage() : false;
    }

    /**
     * @inheritDoc
     */
    public function payUrl()
    {
        return $this->url;
    }

    /**
     * @inheritDoc
     */
    public function hasError()
    {
        return $this->error ? true : false;
    }

    /**
     * @param int $amount
     * @param string $payerName
     * @param string $description
     * @param string $returnUrl
     * @param string $clientRefId
     */
    public function setPayArguments($amount, $payerName, $description, $returnUrl, $clientRefId)
    {
        $this->payArguments = [
                "amount" => $amount,
                "payerName" => $payerName, //نام کاربر پرداخت کننده
                "description" => $description,
                "returnUrl" => $returnUrl,
                "clientRefId" => $clientRefId
        ];
    }
}