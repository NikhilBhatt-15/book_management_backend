<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Book extends Model 
{
    public function cart_items(){
        return $this->belongsToMany('App\Models\CartItem');
    }
    public function categories(){
        return $this->belongsTo('App\Models\Category');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title', 'author','price','rent_price','quantity'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [];
}
