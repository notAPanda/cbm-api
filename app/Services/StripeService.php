<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StripeService
{

    public static function customerCreate(User $user)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $stripeCustomer = $stripe->customers->create([
            'email' => $user->email,
        ]);

        $user->stripe_id = $stripeCustomer->id;
        $user->save();

        return $user;
    }

    public static function sessionCreate(User $user)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $priceId = env('STRIPE_PRICE_ID');

        if (!$user->stripe_id) {
            StripeService::customerCreate($user);
            $user->refresh();
        }

        $session = $stripe->checkout->sessions->create([
            'client_reference_id' => $user->id,
            'customer' => $user->stripe_id,
            'success_url' => env('FRONTEND_APP_URL') . '/subscription/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => env('FRONTEND_APP_URL') . '/subscription',
            'mode' => 'subscription',
            'line_items' => [[
                'price' => $priceId,
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        return $session;

        // Redirect to the URL returned on the Checkout Session.
        // With vanilla PHP, you can redirect with:
        //   header("HTTP/1.1 303 See Other");
        //   header("Location: " . $session->url);
    }

    public static function checkoutSessionCompleted($object)
    {
        $stripe_subscription_id = Arr::get($object, 'subscription');
        $stripe_user_id = Arr::get($object, 'customer');
        $mode = Arr::get($object, 'mode');

        if ($mode !== 'subscription') {
            return false;
        }

        $user = User::where('stripe_id', $stripe_user_id)->first();

        if (!$user) {
            return false;
        }

        $subscription = $user->subscription()->updateOrCreate([], [
            'stripe_id' => $stripe_subscription_id,
        ]);

        return true;
    }

    public static function customerSubscriptionUpdated($object)
    {
        $stripe_subscription_id = Arr::get($object, 'id');

        $subscription = Subscription::where('stripe_id', $stripe_subscription_id)->first();

        if (!$subscription) {
            return false;
        }

        $subscription->update([
            'stripe_status' => Arr::get($object, 'status'),
        ]);

        return true;
    }
    public static function customerSubscriptionDeleted($object)
    {
        $stripe_subscription_id = Arr::get($object, 'id');

        $subscription = Subscription::where('stripe_id', $stripe_subscription_id)->first();

        if (!$subscription) {
            return false;
        }

        $subscription->update([
            'stripe_status' => Arr::get($object, 'status'),
        ]);

        return true;
    }

    public static function invoicePaid($object)
    {
        //
    }

    public static function invoicePaymentFailed($object)
    {
        //
    }

    public static function processWebhook(Request $request)
    {
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

        if ($webhookSecret) {
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $request->getContent(),
                    $request->header('stripe-signature'),
                    $webhookSecret
                );
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        } else {
            $event = $request->all();
        }

        $type = Arr::get($event, 'type');
        $object = Arr::get($event, 'data.object');

        return [$object, $type];
    }
}
