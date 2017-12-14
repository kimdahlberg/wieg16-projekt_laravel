<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Plan;
use Stripe\Stripe;
use Stripe\Subscription;

class StripeController extends Controller
{

    public function index()
    {
        return view("stripe/index");
    }

    public function checkout(Request $request) {
        Stripe::setApiKey("sk_test_zXrrMROGJJLSdgqCIHGnDqzt");
        $input = $request->input();
        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        // Charge the user's card:
        $charge = Charge::create(array(
            "amount" => 19999,
            "currency" => "sek",
            "description" => "Betalning från: ".$input['stripeEmail'],
            "source" => $input['stripeToken'],
        ));
        dd($charge);
    }

//https://stripe.com/docs/api#create_subscription
    public function subscription()
    {
        Stripe::setApiKey("sk_test_zXrrMROGJJLSdgqCIHGnDqzt");
        $plan = Plan::create([
            "name" => "Basic Plan",
            "id" => "basic-monthly", //unikt för ditt konto
            "interval" => "month", // intervall
            "interval_count" => 1,
            "currency" => "sek", // summa ->
            "amount" => 0,
        ]);

        $customer = Customer::create([
            "email" => "testmail@mail.com",
        ]);

        $sub = Subscription::create([
            "customer" => $customer->id,
            "items" => [
                [
                    "plan" => "basic-monthly-free",
                ],
            ],
        ]);

    }
}


