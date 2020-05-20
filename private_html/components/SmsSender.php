<?php
/**
 * Created by PhpStorm.
 * User: y_mobasheri
 * Date: 5/6/2019
 * Time: 12:21 PM
 */

namespace app\components;


use linslin\yii2\curl\Curl;

class SmsSender
{
    private static $apiKey = '5A697836524F664C69666C305834754A696F2F63615A6F4B45754C4E716F704D';
    private static $baseUrl = 'https://api.kavenegar.com/v1/';
    private static $paymentTemplate = 'payment';

    /**
     * @param string $phone
     * @param string $name
     * @param string $cash format 2,000,000 ریال
     * @return bool|mixed|string
     */
    public static function SendPaymentSuccessful($phone, $name, $cash)
    {
        return static::SendTemplate(static::$paymentTemplate, $phone, $name, $cash);
    }

    /**
     * @param string $template
     * @param string $phone
     * @param string $token
     * @param string|bool $token2
     * @param string|bool $token3
     * @return bool|mixed|string
     */
    public static function SendTemplate($template, $phone, $token, $token2 = false, $token3 = false)
    {
        $key = static::$apiKey;
        $url = static::$baseUrl . "{$key}/verify/lookup.json";

        $params = [
            'receptor' => is_array($phone) ? implode(',', $phone) : $phone,
            'token' => $token,
            'template' => $template
        ];

        if ($token2)
            $params['token2'] = $token2;
        if ($token3)
            $params['token3'] = $token3;

        try {
            $curl = new Curl();
            $curl->setPostParams($params);
            return @$curl->post($url, false);
        } catch (\Exception $e) {
            if (!is_dir(\alias('@app/logs/')))
                mkdir(\alias('@app/logs/'), 0755, true);
            $date = date('Y-m-d-H:i:s', time());
            $error = "$date : template: $template - {$e->getMessage()}\n";
            @file_put_contents(\alias('@app/logs/sms_logs.log'), $error, FILE_APPEND);
            return false;
        }
    }

    /**
     * @param array|string $phone number or numbers as array
     * @param string $message content
     * @param string $sender line number
     * @return bool|mixed|string
     */
    public static function Send($phone, $message, $sender = null)
    {
        $key = static::$apiKey;
        $url = static::$baseUrl . "{$key}/sms/send.json";

        $params = [
            'receptor' => is_array($phone) ? implode(',', $phone) : $phone,
            'message' => $message
        ];

        if ($sender)
            $params['sender'] = $sender;

        try {
            $curl = new Curl();
            $curl->setPostParams($params);
            return @$curl->post($url, false);
        } catch (\Exception $e) {
            if (!is_dir(\alias('@app/logs/')))
                mkdir(\alias('@app/logs/'), 0755, true);
            $date = date('Y-m-d-H:i:s', time());
            $error = "$date : simple: $phone - {$e->getMessage()}\n";
            @file_put_contents(\alias('@app/logs/sms_logs.log'), $error, FILE_APPEND);
            return false;
        }
    }

}