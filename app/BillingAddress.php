<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'customer_address_id',
        'email',
        'firstname',
        'lastname',
        'postcode',
        'street',
        'city',
        'telephone',
        'country_id',
        'address_type',
        'company',
        'country',
        'id',

    ];

    public function order(){
        return $this->hasOne(Order::class);
    }
}
