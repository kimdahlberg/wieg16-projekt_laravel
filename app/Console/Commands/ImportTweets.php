<?php

namespace App\Console\Commands;

use App\Tweet;
use Illuminate\Console\Command;

class ImportTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tweets';

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
            CURLOPT_URL => "https://api.twitter.com/1.1/search/tweets.json?q=metoo",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer AAAAAAAAAAAAAAAAAAAAAN2r3QAAAAAAY0PMVaZF3h2FQqwUs5avEgsDhXI%3D7GZeYHWEnVAr6ajbcfLRMIzeYtgwWrfv5sCsSATYjqXsS6veyq",
                "cache-control: no-cache",
                "postman-token: 58b555df-f78f-df65-2283-880ad8d5c0be"
            ),
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        foreach ($response['statuses'] as $item) {
            $tweets = Tweet::findOrNew($item['id']);
            $this->info("Importing tweets: " . $item['id']);
            $tweets->fill($item);
            $tweets->save();
        }
    }
}
