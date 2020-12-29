<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=['payment_status','status','approved_at','delivered_within'];
    protected $dates=['approved_at'];

    public function getDeliveredWithinAttribute($value){
        return str_replace('_',' ',$value);
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class)->withDefault();
    }
    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
    public function table(){
        return $this->belongsTo(Table::class)->withDefault();
    }
    public function details(){
        return $this->hasMany(OrderDetails::class);
    }
}
