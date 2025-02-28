<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreInvocesRequest;
use App\Http\Requests\UpdateInvocesRequest;
use App\Models\Invoce;

use App\Service\MercadoPago;

class InvocesController extends Controller
{
    
    public function pixPayment(Request $request, Invoce $invoce)
    {
        if($invoce->payment_id){
            $back = MercadoPago::getPayment($invoce->payment_id);

            $back = json_decode($back);

            dd($back);
        }

        $data = (object) [
            'reference'     => $invoce->id,
            'amount'        => $invoce->subscriber->subscription->transaction_amount,
            'description'   => $invoce->subscriber->subscription->reason,
            'email'         => $invoce->subscriber->user->email,
        ];

        $back = MercadoPago::pix($data);

        $back = json_decode($back);

        $invoce->payment_id         = $back->id;
        $invoce->payer_email        = $back->payer->email;
        $invoce->taxes_amount       = $back->taxes_amount;
        $invoce->transaction_amount = $back->transaction_amount;
        $invoce->net_received_amount= $back->transaction_details->net_received_amount;
        $invoce->total_paid_amount  = $back->transaction_details->total_paid_amount;
        $invoce->payment_method_id  = $back->payment_method_id;
        $invoce->payment_type_id    = $back->payment_type_id;
        $invoce->currency_id        = $back->currency_id;
        $invoce->qr_code_base64     = $back->point_of_interaction->transaction_data->qr_code_base64;
        $invoce->qr_code            = $back->point_of_interaction->transaction_data->qr_code;
        $invoce->ticket_url         = $back->point_of_interaction->transaction_data->ticket_url;
        $invoce->date_created       = $back->date_created;
        $invoce->date_approved      = $back->date_approved;
        $invoce->date_last_updated  = $back->date_last_updated;
        $invoce->status             = $back->status;
        $invoce->status_detail      = $back->status_detail;

        $invoce->save();
        
        dd($back);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvocesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoce $invoce)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoce $invoce)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvocesRequest $request, Invoce $invoce)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoce $invoce)
    {
        //
    }
}
