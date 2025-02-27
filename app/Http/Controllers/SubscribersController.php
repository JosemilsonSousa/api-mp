<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscribersRequest;
use App\Http\Requests\UpdateSubscribersRequest;

use App\Models\Subscriber;
use App\Models\Invoce;

use App\Service\MercadoPago;

use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;
use Inertia\Response;

class SubscribersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Subscribers', [
            'subscribers' => Subscriber::query()->with(['user','subscription'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subscriber = new Subscriber;
        $subscriber->user_id              = Auth::user()->id;
        $subscriber->church_id            = 2;
        $subscriber->subscription_plan_id = 1;
        $subscriber->last_event_at        = date('Y-m-d');
        $subscriber->next_charge_at       = date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 months'));
        $subscriber->status               = 'pending';
        $subscriber->save();

        $invoce = new Invoce;
        $invoce->subscriber_id     = $subscriber->id;
        $invoce->payment_method_id = '';
        $invoce->payment_type_id   = '';
        $invoce->payer_email       = Auth::user()->email;
        $invoce->status            = 'pending';
        $invoce->save();

        return redirect()->route('dash.assinantes');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscribersRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscriber $subscriber)
    {
        return Inertia::render('Subscriber', [
            'subscriber'=> $subscriber,
            'invoces'   => $subscriber->invoces,
            'user'      => $subscriber->user,
            'plan'      => $subscriber->subscription->reason,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscriber $subscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscribersRequest $request, Subscriber $subscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        //
    }
}
