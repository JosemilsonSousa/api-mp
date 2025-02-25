<?php
/**
 * Conexão com a API do Mercado
*/
namespace App\Service;

class MercadoPago
{
    /*** Parâmetros de Autenticação ***/
    private static $url;
    private static $email;

    private static $publicKey;
    private static $token;
    private static $client_Id;
    private static $clientSecret;

    private static $xIdempotencyKey;

    private static $success_url;
    private static $pending_url;
    private static $failure_url;
    private static $notification_url;

    private static $verb;
    private static $callBack;
    private static $data;


    public static function createPlan($data)
    {
        self::$token = ENV('MP_TOKEN');
        self::$verb  = "POST";
        self::$url   = "https://api.mercadopago.com/preapproval_plan";
        self::$data  = [
            'auto_recurring' => [
                'frequency'                 => 1,
                'frequency_type'            => "months",
                'billing_day_proportional'  => false,
                'transaction_amount'        => $data->amount,
                'currency_id'               => "BRL"
            ], 
            'back_url'          => ENV('MP_BACK_URL'),
            'payment_methods_allowed' => [
                'payment_types'     => [ ['id' => 'credit_card'] ],
                'payment_methods'   => [ ['id' => 'bolbradesco'] ]
            ],
            'reason' => $data->reason
        ];

        self::$callBack = self::post();
        return self::$callBack;
    }

    public static function getPayment($paymentId)
    {
        self::$verb = "GET";
        self::$url  = "https://api.mercadopago.com/v1/payments/{$paymentId}";
        self::$callBack = self::post();
        return self::$callBack;

    }

    public static function getPlan($idPlan)
    {
        self::$verb = "GET";
        self::$url  = "https://api.mercadopago.com/preapproval_plan/{$idPlan}";
        self::$callBack = self::post();
        return self::$callBack;
    }

    public static function payPix()
    {
        self::$verb = "POST";
        self::$url  = "https://api.mercadopago.com/v1/payments";
        self::$data = [
            'callback_url' => "http://localhost/pagamento-concluido",
            'description'  => "Assinatura Admin Church",
            'external_reference' => "MP0001",
            'payer' => [
                'email' => "rbedasilva@gmail.com",
                'identification' => [ 'type' => "CPF", 'number' => "02652831321" ]
            ],
            'payment_method_id'  => "pix",
            'transaction_amount' => 0.25
        ];

        self::$callBack = self::post();
        return self::$callBack;
    }

    /**
     * Method responsible for sending the request
     * @param self::$url.
     * @param self::$verb.
     * @param self::$data.
     * @param self::getToken().
     * @return self::$callBack.
     */
    private static function post()
    {
        $url = curl_init(self::$url);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($url, CURLOPT_ENCODING, '');
        curl_setopt($url, CURLOPT_MAXREDIRS,  10);
        curl_setopt($url, CURLOPT_TIMEOUT,  0);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION,  true);
        curl_setopt($url, CURLOPT_HTTP_VERSION,  CURL_HTTP_VERSION_1_1);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, self::$verb);
        
        if(self::$verb == "POST")
            curl_setopt($url, CURLOPT_POSTFIELDS, json_encode(self::$data));
        
        curl_setopt($url, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Idempotency-Key: ' . self::get_xIdempotencyKey(),
            'Authorization: Bearer ' . self::$token
        ));

        return curl_exec($url);
        curl_close($url);
    }

    private static function get_xIdempotencyKey()
    {
        self::$xIdempotencyKey = bin2hex(random_bytes(15));
        self::$xIdempotencyKey .= uniqid();

        return self::$xIdempotencyKey;
    }

}