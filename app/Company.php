<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

        public $incrementing = false;
        public $timestamps = false;

        protected $fillable = [
        'id',
        'company_name',

    ];

        public function customer(){
            return $this->belongsTo(Customer::class);
        }
}
