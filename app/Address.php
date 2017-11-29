<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
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
    ];
}
