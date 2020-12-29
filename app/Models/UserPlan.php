<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    use HasFactory;

    protected $dates=['expired_date'];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function plan(){
        return $this->belongsTo(Plan::class,'plan_id','id');
    }
}
