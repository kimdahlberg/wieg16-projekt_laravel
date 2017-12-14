<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/customers', 'CustomerController@getCustomers');


Route::get('/customers/{id}', 'CustomerController@showIdCustomer');
Route::get('/customers/{id}/address', 'CustomerController@showCustomerAddress');
Route::get('/customers/companyid/{id}', 'CustomerController@showCompanyId');
Route::get('/stripe', 'StripeController@index');
Route::get('/billingaddress', 'BillingAddressController@showBillingAddress');
Route::get('/shippingaddress', 'ShippingAddressController@showShippingAddress');
Route::get('/item', 'ItemController@showItems');
Route::get('/order', 'OrderController@showOrders');

Route::resource('products', 'ProductController');
Route::resource('groups', 'GroupController');
Route::resource('prices', 'GroupPriceController');

//Instagram
Route::get('/images', 'InstagramController@showImages');

//Twitter
Route::get('/tweets', 'TweetController@showTweets');
Route::get('/count', 'TweetController@callTweetCount');
Route::get('/exclude', 'TweetController@exclude');
Route::get('/tweetForm', 'TweetController@tweetForm');

//Klarna
Route::get('/klarna', 'KlarnaController@index');
Route::get('/klarna-confirmation', 'KlarnaController@confirmation');
Route::get('/klarna-acknowledge', 'KlarnaController@acknowledge');