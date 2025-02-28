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

    /**
     * -----------------------------------------------------------------------------------------
     * Method responsible for create ticket
     * @param $data
     * @return self::$callBack.
     * -----------------------------------------------------------------------------------------
     */
    public static function ticket($data)
    {
        self::$verb  = "POST";
        self::$url   = "https://api.mercadopago.com/v1/payments";
        self::$data  = [
            "external_reference" => "invoce-",
            "transaction_amount" => 1.00,
            "description"        => "Título do produto",
            "payment_method_id"  => "bolbradesco",
            "payer" => [
                "email"          => "rbedasilva@gmail.com",
                "first_name"     => "Raimunda",
                "last_name"      => "Bezerra",
                "identification" => [
                    "type"       => "CPF",
                    "number"     => "02652831321"
                ],
                "address" => [
                    "zip_code"      => "65620000",
                    "street_name"   => "Rua Sebastiao Pinto Machado",
                    "street_number" => "33",
                    "neighborhood"  => "Centro",
                    "city"          => "Coelho Neto",
                    "federal_unit"  => "MA"
                ]
            ]
        ];

        self::$callBack = self::post();
        return self::$callBack;
    }


    /**
     * -----------------------------------------------------------------------------------------
     * Methodo responsible for create qrCode pix
     * @param $data
     * @return self::$callBack.
     * -----------------------------------------------------------------------------------------
     */
    public static function pix($data)
    {
        self::$verb  = "POST";
        self::$url   = "https://api.mercadopago.com/v1/payments";
        self::$data  = [
            'external_reference' => "invoce-{$data->reference}",
            'description'        => $data->description,
            'transaction_amount' => (float) $data->amount,
            'payment_method_id'  => "pix",
            'payer' => ['email'  => $data->email],
            'callback_url'       => ENV('MP_BACK_URL'),
            'notification_url'   => ENV('MP_NOTIFICATION_URL'),
        ];

        self::$callBack = self::post();
        return self::$callBack;
    }



    /**
     * Method responsible for sending the request
     * @param self::$url.
     * @param self::$verb.
     * @param self::$data.
     * @param self::token
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
            'Authorization: Bearer ' . ENV('MP_TOKEN')
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