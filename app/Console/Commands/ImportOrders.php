<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\BillingAddress;
use App\ShippingAddress;
use App\Order;
use App\Item;
use DB;



class ImportOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:orders';

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
            CURLOPT_URL => "https://www.milletech.se/invoicing/export/",
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

        foreach ($response as $order) {
            $this->info("Inserting/updating processing orders:" . $order['id']);

            if ($order['status'] != 'processing') continue;

            $dbInvoice = Order::findOrNew($order['id']);
            $dbInvoice->fill($order)->save();

            if (isset($order['shipping_address']) && is_array($order['shipping_address'])){
                $dbShipping = ShippingAddress::findOrNew($order['shipping_address']['id']);
                $dbShipping->fill($order['shipping_address'])->save();
            }
            if (isset($order['billing_address']) && is_array($order['billing_address'])){
                $dbBilling = BillingAddress::findOrNew($order['billing_address']['id']);
                $dbBilling->fill($order['billing_address'])->save();
            }
            foreach ($order['items'] as $item){
                $orderItem = Item::findOrNew($item['id']);
                $orderItem->fill($item)->save();
            }
        }

    }
}

