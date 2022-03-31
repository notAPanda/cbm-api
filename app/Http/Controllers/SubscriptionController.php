<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\StripeService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function sessionCreate(Request $request)
    {
        $user = $request->user();

        $session = StripeService::sessionCreate($user);

        return [
            'session_url' => $session->url,
            'user' => $user,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscriptionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubscriptionRequest  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    public function webhook(Request $request)
    {
        [$object, $type] = StripeService::processWebhook($request);

        switch ($type) {
            case 'checkout.session.completed':
                StripeService::checkoutSessionCompleted($object);
                break;
            case 'invoice.paid':
                StripeService::invoicePaid($object);
                break;
            case 'invoice.payment_failed':
                StripeService::invoicePaymentFailed($object);
                break;
            case 'customer.subscription.updated':
                StripeService::customerSubscriptionUpdated($object);
                break;
            case 'customer.subscription.deleted':
                StripeService::customerSubscriptionDeleted($object);
                break;

                // ... handle other event types
            default:
                // Unhandled event type
        }

        return response()->json(['status' => 'success']);
    }
}
