<?php

namespace App\Http\Controllers;

use Stripe\StripeClient;

class StripeController extends Controller
{
    /**
     * Create a customer at stripe
     *
     * @return \Stripe\Customer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function customerCreate()
    {
        $stripe   = new StripeClient(env('STRIPE_SECRET'));
        $customer = $stripe->customers->create(
            [
                'description'    => 'example customer',
                'email'          => 'email@example.com',
                'payment_method' => 'pm_card_visa',
            ]
        );
        return $customer;
    }
}
