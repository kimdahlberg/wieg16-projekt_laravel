<?php

namespace App\Console\Commands;

use App\Address;
use App\Customer;
use App\Company;
use DB;
use Illuminate\Console\Command;

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.milletech.se/invoicing/export/customers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 441e1d3c-9673-9b53-3d91-9deb5afdbadd"
            ),
        ));

        $response = curl_exec($curl);

        $response = json_decode($response, true);
        $err = curl_error($curl);

        curl_close($curl);
        $companies = [];
        foreach ($response as $customer) {
            $this->info("Inserting/updating customer with id: " . $customer['id']);
            $dbCustomer = Customer::findOrNew($customer['id']);
            $dbCustomer->fill($customer)->save();
            $companies[] = $customer['customer_company'];

            if (isset($customer['address']) && is_array($customer['address'])) {
                $address = Address::findOrNew($customer['address']['id']);
                $address->fill($customer['address'])->save();
            }
        }

        $companies = array_unique($companies);

        foreach ($companies as $company) {
            $customerCompany = Company::where('company_name', '=', $company)->first();
            if ($customerCompany == null)
                $customerCompany = new Company();

            $customerCompany->fill(['company_name' => $company])->save();

            DB::table('customers')
                ->where('customer_company', '=', $customerCompany->company_name)
                ->update(['company_id' => $customerCompany->id]);
        }

    }
}