<?php

namespace App\Http\Controllers\GetWay;

use App\Http\Controllers\Controller;

use App\Models\SubscriptionPlan;

use App\Service\MercadoPago;

use Illuminate\Http\Request;

class GetWayController extends Controller
{
    public function createPlan()
    {
        $data = (object) [
            'amount' => "1.00",
            'reason' => "Assinatura SysEBD",
            'xIdempotencyKey' => ''
        ];

        $back = MercadoPago::createPlan($data);
        
        echo "<pre>";
            dump(json_decode($back, JSON_PRETTY_PRINT));
        echo "</pre>";

        $back = json_decode($back);

        $plan = new SubscriptionPlan;
        $plan->preapproval_plan_id  = $back->id;
        $plan->back_url             = $back->back_url;
        $plan->collector_id         = $back->collector_id;
        $plan->application_id       = $back->application_id;
        $plan->reason               = $back->reason;
        $plan->status               = $back->status;
        $plan->date_created         = $back->date_created;
        $plan->last_modified        = $back->last_modified;
        $plan->init_point           = $back->init_point;

        $plan->frequency            = $back->auto_recurring->frequency;
        $plan->frequency_type       = $back->auto_recurring->frequency_type;
        $plan->transaction_amount   = $back->auto_recurring->transaction_amount;
        $plan->currency_id          = $back->auto_recurring->currency_id;

        $plan->save();
        
        echo "<pre>";
            dump(json_encode($plan, JSON_PRETTY_PRINT));
        echo "</pre>";



    } 
}
