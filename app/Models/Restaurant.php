<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable=['name','email','phone_number','location','timing','description','profile_image','cover_image','slug','status'];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
    public function items(){
        return $this->hasMany(Item::class);
    }
    public function tables(){
        return $this->hasMany(Table::class);
    }

    public function setDescriptionAttribute($value){
        $this->attributes['description']=clean($value);
    }
}
