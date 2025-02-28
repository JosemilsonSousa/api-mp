<?php

namespace App\Http\Controllers\GetWay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class MercadoPagoController extends Controller
{
    public function createPix()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "external_reference": "invoce-",
                "transaction_amount": 100,
                "payment_method_id": "pix",
                "payer": {
                    "email": "rbedasilva@gmail.com"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'Authorization: Bearer TEST-4540297156019381-022021-52d777da15eec41b6cdbf19d7b94862b-75406800',
                'X-Idempotency-Key: 0d5020ed-1af6-469c-ae06-c3bec19954bb56'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function createBoleto()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
              "transaction_amount": 100,
              "description": "Título do produto",
              "payment_method_id": "bolbradesco",
              "payer": {
                "email": "rbedasilva@gmail.com",
                "first_name": "Raimunda",
                "last_name": "Bezerra",
                "identification": {
                    "type": "CPF",
                    "number": "02652831321"
                },
                "address": {
                    "zip_code": "06233200",
                    "street_name": "Av. das Nações Unidas",
                    "street_number": "3003",
                    "neighborhood": "Bonfim",
                    "city": "Osasco",
                    "federal_unit": "SP"
                }
              }
            }',
          CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'content-type: application/json',
            'Authorization: Bearer TEST-4540297156019381-022021-52d777da15eec41b6cdbf19d7b94862b-75406800',
            'X-Idempotency-Key: 0d5020ed-1af6-469c-ae06-c3bec19954bb26'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }
    public function createPreference()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.mercadopago.com/checkout/preferences',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "items": [
            {
              "id": "Sound system",
              "title": "Dummy Title",
              "description": "Dummy description",
              "quantity": 1,
              "currency_id": "BRL",
              "unit_price": 10
            }
          ],
          "payer": {
            "name": "John",
            "surname": "Doe",
            "email": "john@doe.com",
            "identification": {
              "type": "CPF",
              "number": "19119119100"
            },
            "date_created": "2024-04-01T00:00:00Z"
          },
          "payment_methods": {
            "excluded_payment_methods": [
              {
                "id": "master"
              }
            ],
            "excluded_payment_types": [
              {
                "id": "wallet"
              },
              {
                "id": "mercadoPago"
              }
            ],
            "default_payment_method_id": "visa",
            "installments": 1,
            "default_installments": 1
          },
          "back_urls": {
            "success": "https://test.com/success",
            "pending": "https://test.com/pending",
            "failure": "https://test.com/failure"
          },
          "notification_url": "https://notificationurl.com",
          "auto_return": "approved",
          "external_reference": "1643827245",
          "expires": false,
          "marketplace": "NONE",
          "marketplace_fee": 0,
          "differential_pricing": {
            "id": 1
          },
          "metadata": null
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . ENV('MP_TOKEN')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }


}
