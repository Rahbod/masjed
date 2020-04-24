<?php


namespace app\components\gateway;


interface GatewayInterface
{
    /**
     * Pay Request
     */
    public function pay();

    /**
     * Verify Request
     *
     * @param int $amount
     * @return bool|string
     */
    public function verify($amount);

    /**
     * @return string
     */
    public function payUrl();

    /**
     * @return bool
     */
    public function hasError();

    /**
     * @return string
     */
    public function errorMessage();
}