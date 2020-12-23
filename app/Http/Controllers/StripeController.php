<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Balance;
use Stripe\Charge;
use Stripe\Collection;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
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
     * @return Collection
     * @throws ApiErrorException
     */
    public function customers()
    {
        $customer = $this->stripe->customers->all();
        return $customer;
    }

    /**
     * Create a customer at stripe
     *
     * @return Customer
     * @throws ApiErrorException
     */
    public function customerCreate()
    {
        $customer = $this->stripe->customers->create(
            [
                'description'    => 'Amir Hossain',
                'email'          => 'amir@test.com',
                'payment_method' => 'pm_card_visa',
                'balance'        => -5000000,
            ]
        );
        return $customer;
    }

    /**
     * Create a customer at stripe
     *
     * @return Customer
     * @throws ApiErrorException
     */
    public function retriveCustomer(Request $request)
    {
        $customer = $this->stripe->customers->retrieve($request->cutomer_id, []);
        return $customer;
    }

    /**
     * Update a customer at stripe
     *
     * @return Customer
     * @throws ApiErrorException
     */
    public function updateCustomer(Request $request)
    {
        $customer = $this->stripe->customers->update(
            $request->cutomer_id,
            [
                'description' => 'Mehedi Hasan',
                'email'       => 'mehedi@test.com',
                'balance'     => -5000000,
                'metadata'    => [
                    'order_id' => '6735',
                ],
            ]
        );
        return $customer;
    }

    /**
     * Delete a customer at stripe
     *
     * @return Customer
     * @throws ApiErrorException
     */
    public function deleteCustomer(Request $request)
    {
        $customer = $this->stripe->customers->delete(
            $request->cutomer_id,
            []
        );
        return $customer;
    }

    /**
     * Create a charge from customer
     *
     * @return Charge
     * @throws ApiErrorException
     */
    public function createCharge()
    {
        $charge = $this->stripe->charges->create(
            [
                'amount'      => 2000,
                'currency'    => 'usd',
                'source'      => 'tok_mastercard',
                'description' => 'My First Test Charge (created for API docs)',
            ]
        );
        return $charge;
    }

    /**
     * Create authorize hold for customer
     *
     * @return Charge
     * @throws ApiErrorException
     */
    public function authorizeHold()
    {
        $charge = $this->stripe->charges->create(
            [
                'amount'      => 20000,
                'currency'    => 'usd',
                'source'      => 'tok_mastercard',
                'description' => 'My First Authorize Hold of 200 USD',
                'capture'     => false,
            ]
        );
        return $charge;
    }

    /**
     * Create a charge from customer
     *
     * @return Charge
     * @throws ApiErrorException
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
     * @return Charge
     * @throws ApiErrorException
     */
    public function retrieveCharge(Request $request)
    {
        $charge = $this->stripe->charges->retrieve($request->transaction_id, []);
        return $charge;
    }

    /**
     * Retrieve all charges
     *
     * @return Collection
     * @throws ApiErrorException
     */
    public function retrieveCharges()
    {
        $charges = $this->stripe->charges->all(['limit' => 3]);
        return $charges;
    }


    /**
     * Create a charge from customer
     *
     * @return \Stripe\PaymentMethod
     * @throws ApiErrorException
     */
    public function createPaymentMethod()
    {
        $paymentMethod = $this->stripe->paymentMethods->create(
            [
                'type' => 'card',
                'card' => [
                    'number'    => '4242424242424242',
                    'exp_month' => 12,
                    'exp_year'  => 2021,
                    'cvc'       => '314',
                ],
            ]
        );
        return $paymentMethod;
    }

    /**
     * Create a charge from customer
     *
     * @return \Stripe\PaymentMethod
     * @throws ApiErrorException
     */
    public function attachPaymentMethod(Request $request)
    {
        $paymentMethod = $this->stripe->paymentMethods->attach($request->payment_method_id, ['customer' => $request->customer_id]);
        return $paymentMethod;
    }

    /**
     * Create a charge from customer
     *
     * @return \Stripe\PaymentIntent
     * @throws ApiErrorException
     */
    public function createPaymentIntent()
    {
        $paymentIntent = $this->stripe->paymentIntents->create(
            [
                'amount'               => 2000,
                'currency'             => 'usd',
                'payment_method_types' => ['card'],
                'confirm'              => true,
            ]
        );
        return $paymentIntent;
    }

    /**
     * Create a charge from customer
     *
     * @return \Stripe\PaymentIntent
     * @throws ApiErrorException
     */
    public function createPaymentIntentHold(Request $request)
    {
        $paymentIntent = $this->stripe->paymentIntents->create(
            [
                'amount'               => 20000,
                'currency'             => 'usd',
                'payment_method_types' => ['card'],
                'confirm'              => true,
                'capture_method'       => 'manual',
                'payment_method'       => $request->payment_method_id,
                'customer'             => $request->customer_id,
            ]
        );

        return $paymentIntent;
    }

    /**
     * Create a charge from customer
     *
     * @return \Stripe\PaymentIntent
     * @throws ApiErrorException
     */
    public function capturePaymentIntentHold(Request $request)
    {
        $paymentIntent = $this->stripe->paymentIntents->capture($request->payment_intent_id, []);
        return $paymentIntent;
    }

    /**
     * Create a charge from customer
     *
     * @return \Stripe\PaymentIntent
     * @throws ApiErrorException
     */
    public function cancelPaymentIntentHold(Request $request)
    {
        $paymentIntent = $this->stripe->paymentIntents->cancel($request->payment_intent_id, [
            'cancellation_reason' => 'abandoned'
        ]);
        return $paymentIntent;
    }

    /**
     * Create a charge from customer
     *
     * @return \Stripe\PaymentIntent
     * @throws ApiErrorException
     */
    public function retrievePaymentIntent(Request $request)
    {
        $paymentIntent = $this->stripe->paymentIntents->retrieve($request->payment_intent_id, []);
        return $paymentIntent;
    }

    /**
     * Retrieve merchant balance
     *
     * @return Balance
     * @throws ApiErrorException
     */
    public function retrieveBalance()
    {
        $balance = $this->stripe->balance->retrieve();
        return $balance;
    }

    /**
     * Retrieve transaction history for merchant
     *
     * @return Collection
     * @throws ApiErrorException
     */
    public function retrieveTransactionHistory()
    {
        $balance = $this->stripe->balanceTransactions->all();
        return $balance;
    }
}
