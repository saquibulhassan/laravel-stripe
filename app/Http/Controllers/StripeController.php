<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Balance;
use Stripe\StripeClient;

class StripeController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    /**
     * Create a customer at stripe
     *
     * @return \Stripe\Customer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function customerCreate()
    {
        $customer = $this->stripe->customers->create(
            [
                'description'    => 'Saquibul Hasan Razib',
                'email'          => 'saquib@test.com',
                'payment_method' => 'pm_card_visa',
            ]
        );
        return $customer;
    }

    /**
     * Create a charge from customer
     *
     * @return \Stripe\Charge
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createCharge()
    {
        $charge = $this->stripe->charges->create(
            [
                 'amount' => 2000,
                 'currency' => 'usd',
                 'source' => 'tok_mastercard',
                 'description' => 'My First Test Charge (created for API docs)',
             ]
        );
        return $charge;
    }

    /**
     * Create authorize hold for customer
     *
     * @return \Stripe\Charge
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function authorizeHold()
    {
        $charge = $this->stripe->charges->create(
            [
                 'amount' => 20000,
                 'currency' => 'usd',
                 'source' => 'tok_mastercard',
                 'description' => 'My First Authorize Hold of 200 USD',
                 'capture' => false,
             ]
        );
        return $charge;
    }

    /**
     * Create a charge from customer
     *
     * @return \Stripe\Charge
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function authorizeHoldCapture(Request $request)
    {
        $charge = $this->stripe->charges->capture($request->transaction_id, [
            //'amount' => 1000
        ]);
        return $charge;
    }

    /**
     * Retrieve charge by transaction id
     *
     * @return \Stripe\Charge
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function retrieveCharge(Request $request)
    {
        $charge = $this->stripe->charges->retrieve($request->transaction_id, []);
        return $charge;
    }

    /**
     * Retrieve all charges
     *
     * @return \Stripe\Collection
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function retrieveCharges()
    {
        $charges = $this->stripe->charges->all(['limit' => 3]);
        return $charges;
    }

    /**
     * Retrieve merchant balance
     *
     * @return Balance
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function retrieveBalance()
    {
        $balance = $this->stripe->balance->retrieve();
        return $balance;
    }

    /**
     * Retrieve transaction history for merchant
     *
     * @return \Stripe\Collection
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function retrieveTransactionHistory()
    {
        $balance = $this->stripe->balanceTransactions->all();
        return $balance;
    }
}
