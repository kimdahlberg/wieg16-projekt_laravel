<?php

namespace App\Console\Commands;
use App\Customer;
use App\Company;
use DB;
use Illuminate\Console\Command;

class ImportCompanies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:companies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'importera företag';

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
        $customer = Customer::all();

        $companies = [];
        foreach ($customer as $item) {
            $companies[] = $item['customer_company'];
        }
        $companies = array_values(array_unique($companies));

        $this->info("Found " . count($companies) . " companies");
        foreach ($companies as $company) {
            $this->info("Inserting/updating company: " . $company);
            $customerCompany = Company::where('company_name', '=', $company)->first();
            if ($customerCompany == null)
                $customerCompany = new Company();
            $customerCompany->fill(['company_name' => $company])->save();
        }

        $customer_companies = Company::all();
        foreach ($customer_companies as $customer_company) {
            $this->info("Updating customers with company_id: " . $customer_company->id);
            DB::table('customers')->where('customer_company', '=', $customer_company->company_name)->update(['company_id' => $customer_company->id]);
        }
    }
}
