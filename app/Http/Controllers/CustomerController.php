<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Address;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getCustomers(){
     return response()->json(Customer::all());
    }

    public function showIdCustomer($id){
        $customer = Customer::Find($id);
        if ($customer == true){
            return response()->json($customer);
        } else {
            return response()->json(["Message:" => "Customer not found"], 404);
        }
    }

    public function showCustomerAddress($id){

        $customer_address_id = Address::select('street', 'postcode', 'city', 'country')->where('customer_id', $id)->get();
        if (count($customer_address_id) > 0) {
            return response()->json($customer_address_id);
        } else {
            return response()->json(["Message:" => "Customer not found"], 404);
        }
    }

    public function CreateCompaniesTable(){

    }

    public function showCustomerId() {

    }
}