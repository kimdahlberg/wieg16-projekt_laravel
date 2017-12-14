<?php

namespace App\Console\Commands;

use App\Image;
use App\InstaUser;
use Illuminate\Console\Command;

class ImportImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:images';

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
            CURLOPT_URL => "https://api.instagram.com/v1/users/self/media/recent?access_token=25151595.6585b7d.89aa102b5d984248a5df470eddfbfe34",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"client_id\"\r\n\r\n6585b7da7d7d4c3096d02cefd8ec91ac\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"client_secret\"\r\n\r\n5b9169e6757f4ff4aebe7359c61718f3\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"grant_type\"\r\n\r\nauthorization_code\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"redirect_uri\"\r\n\r\nhttp://medieinstitutet.se/\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"code\"\r\n\r\ncc2c745e2e374b11b47c03b8b4558c1a\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER => array(
                "access_token: 25151595.6585b7d.89aa102b5d984248a5df470eddfbfe34",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
                "postman-token: 460baba1-7f2f-5d18-130a-d4e4c95202af"
            ),
        ));

        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);

        foreach ($response['data'] as $data) {

            $caption = Image::findOrNew($data['caption']['id']);
            $this->info("Importing images: " . $data['caption']['id']);
            $caption->fill($data['caption']);
            foreach ($data['images'] as $image) {
                $image['text'] = "";
                $caption->fill($image);
                $caption->save();

            }
        }
    }
}