<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable=['restaurant_id','category_id','name','details','price','discount_to','discount','discount_type','status','image'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
