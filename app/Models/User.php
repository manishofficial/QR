<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function restaurants(){
        return $this->hasMany(Restaurant::class);
    }

    public function active_restaurants(){
        return $this->restaurants()->where('status','active');
    }
    public function categories(){
        return $this->hasMany(Category::class);
    }
    public function active_categories(){
        return $this->categories()->where('status','active');
    }
    public function items(){
        return $this->hasMany(Item::class);
    }
    public function user_plans(){
        return $this->hasMany(UserPlan::class);
    }
    public function current_plans(){
        return $this->user_plans()->where('is_current','yes')->orderByDesc('created_at')->where(function($q){
            $q->where('expired_date','>',now())->orWhereNull('expired_date');
        });
    }
    public function tables(){
        return $this->hasMany(Table::class);
    }
}
