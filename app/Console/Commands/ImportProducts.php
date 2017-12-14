<?php

namespace App\Console\Commands;

use App\Group;
use App\GroupPrice;
use App\Product;
use ClassesWithParents\G;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

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

    private function getProducts($fileName) {
        if (!Storage::exists($fileName)) {
            $curl = curl_init();

            $this->info("File not found, getting product data...");
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://www.milletech.se/invoicing/export/products",
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "cache-control: no-cache",
                    "postman-token: bd05442d-8db7-a282-6905-6bfd985990e2"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            Storage::put($fileName, $response);
        }

        return json_decode(Storage::get($fileName), true);
    }

    public function handle()
    {
        $this->info('Starting product import!');
        $fileName = 'products.json';
        $products = $this->getProducts($fileName);
        $this->info('Loading product data from file');
        $this->info("Found " . count($products['products']) . " products");

        foreach ($products['products'] as $product) {
            $this->info('Inserting/updating products with id: ' . $product['entity_id']);
            $dbProduct = Product::findOrNew($product['entity_id']);
            $dbProduct->fill($product)->save();

            foreach ($product['group_prices'] as $prices) {
                $prices['product_id'] = $product['entity_id'];
                //dd($prices);
                GroupPrice::create($prices);
            }
        }
        foreach ($products['groups'] as $group) {
            $this->info('Inserting/updating group with id: ' . $group['customer_group_id']);
            $dbGroup = Group::findOrNew($group['customer_group_id']);
            $dbGroup->fill($group)->save();
        }    }
}
