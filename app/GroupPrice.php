<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPrice extends Model
{
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'price',
        'group_id',
        'product_id',
    ];
    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function group() {
        return $this->belongsTo(Group::class);
    }
    public function customer() {
        return $this->belongsToMany(Customer::class);
    }


}
