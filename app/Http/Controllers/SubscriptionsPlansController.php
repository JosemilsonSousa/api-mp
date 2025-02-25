<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptions_PlansRequest;
use App\Http\Requests\UpdateSubscriptions_PlansRequest;
use App\Models\SubscriptionPlan as Plan;
use App\Models\Subscriber;

class SubscriptionsPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('planos', [
            'plans' => Plan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subscriber = new Subscriber;
        $subscriber->user_id = 1;
        $subscriber->church_id = 1;
        $subscriber->subscription_plan_id = 1;
        $subscriber->payment_method = 'credit-card';
        $subscriber->status = 'active';
        $subscriber->save();

        echo $subscriber->id;
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
