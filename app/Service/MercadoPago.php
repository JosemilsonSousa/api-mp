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

    private static $publicKey     = "TEST-9ea97cf4-70ea-48c6-8dd6-90566ba270f4";
    private static $token         = "TEST-7501866225064107-042912-984f8062dfc1859fd2c4100f915d7d00-75406800";

    private static $publicKeyProd = "APP_USR-b70fa981-85ef-4d51-888c-6a3d231cab6d";
    private static $tokenProd     = "APP_USR-4540297156019381-022021-6cdc94bedc45697d39bd64f3dcda3ade-75406800";

    private static $client_Id     = "4540297156019381";
    private static $clientSecret  = "qkF10ev5DNvcWA7sR3bvJlqrEmK7XxTg";

    /***  ***/
    private static $success_url;
    private static $pending_url;
    private static $failure_url;
    private static $notification_url;

    /*** Parâmetros do REST ***/
    private static $verb;
    private static $callBack;
    private static $params;
    private static $data;

    public static function getToken()
    {
        // $response = self::$token;
        $response = self::$tokenProd;
        //if(ENV('API_MP')) $response = self::$tokenProd;
        return $response;
    }

    public static function getVerb()
    {
        return self::$verb;
    }

    public static function getUrl()
    {
        return self::$url;
    }

    public static function getParams()
    {
        return self::$params;
    }

    public static function createPlan()
    {
        self::$verb = "POST";
        self::$url  = "https://api.mercadopago.com/preapproval_plan";
        self::$data = [
            'auto_recurring' => [
                'frequency'      => 1,
                'frequency_type' => "months",
                'billing_day_proportional' => false,
                //'free_trial'     => [ 'frequency' => 0, 'frequency_type' => "months" ],
                'transaction_amount' => 1.00,
                'currency_id'        => "BRL"
            ],
            'back_url' => "https://www.yoursite.com",
            'payment_methods_allowed' => [
                'payment_types'     => [ ['id' => 'credit_card'] ],
                'payment_methods'   => [ ['id' => 'bolbradesco'] ]
            ],
            'reason' => "Church Admin - teste R$1,00"
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
            // 'callback_url' => "http://localhost/pagamento-concluido",
            'callback_url' => [
                'success' => "http://localhost/concluido",
                'pending' => "http://localhost/pendente",
                'failure' => "http://localhost/falhou"
            ],
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
        // curl_setopt($url, CURLOPT_SSL_VERIFYPEER, true);
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
            'X-Idempotency-Key: 0d5020ed-1af6-469c-ae06-c3bec19954ba',
            'Authorization: Bearer ' . self::getToken()
        ));

        return curl_exec($url);
        curl_close($url);
    }

}