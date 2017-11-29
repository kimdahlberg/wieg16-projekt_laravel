<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'firstname',
        'lastname',
        'gender',
        'customer_activated',
        'group_id',
        'customer_company',
        'default_billing',
        'default_shipping',
        'is_active',
        'customer_extra_text',
        'customer_due_date_period',
    ];
    /* // Länka modellen till en annan tabell
 protected $table = 'my_customers';

 // Primary key-kolumnen antas vara id
 protected $primaryKey = 'id';

 // Primary key-kolumnen antas vara auto-inkrementerande
 public $incrementing = true;

 // Laravel sköter timestamps åt dig om du inte säger nej
 public $timestamps = false;*/

    public function companies(){
        return $this->hasOne(Company::class);
    }


}


