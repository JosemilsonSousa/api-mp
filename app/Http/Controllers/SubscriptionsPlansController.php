<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptions_PlansRequest;
use App\Http\Requests\UpdateSubscriptions_PlansRequest;

use App\Models\SubscriptionPlan as Plan;
use App\Models\Subscriber;
use App\Service\MercadoPago;

use Inertia\Inertia;
use Inertia\Response;

class SubscriptionsPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Subscriptions', [
            'plans' => Plan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = (object) [
            'amount' => "1.25",
            'reason' => "Assinatura SysEBD",
        ];

        $back = MercadoPago::createPlan($data);

        $back = json_decode($back);

        $plan = new Plan;
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

        return redirect()->route('dash.planos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptions_PlansRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscriptions_Plans $subscriptions_Plans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscriptions_Plans $subscriptions_Plans)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptions_PlansRequest $request, Subscriptions_Plans $subscriptions_Plans)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriptions_Plans $subscriptions_Plans)
    {
        //
    }
}
