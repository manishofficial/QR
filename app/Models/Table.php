<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $fillable=['user_id','restaurant_id','name','no_of_capacity','position','status'];
    public function restaurant(){
        return $this->belongsTo(Restaurant::class,'restaurant_id','id');
    }
}
