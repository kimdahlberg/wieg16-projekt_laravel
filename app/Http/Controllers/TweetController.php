<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TweetController extends Controller
{
    public function showTweets()
    {
        $tweets = Tweet::all();
        return View('twitter/tweets', ['tweets' => $tweets]);
    }
    public function callTweetCount()
    {
        $tweets = Tweet::all();
        $result = Tweet::count_words($tweets);
        return response()->json($result);
    }
    public function exclude()
    {
        $tweets = Tweet::all();
        $result = Tweet::excludeWords($tweets);
        return response()->json($result);
    }
    public function tweetForm()
    {
        $search = "";
        $tweet = [];
        if (isset($_GET["search"]))
        {
            $search = $_GET['search'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.twitter.com/1.1/search/tweets.json?q='.$search.'",
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
            $tweet = Tweet::count_words($response);
        }
        return View('twitter/tweetForm', ['tweets' => $tweet]);
    }
}
