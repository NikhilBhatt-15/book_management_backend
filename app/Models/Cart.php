<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    public function users(){
        return $this->belongsTo('App\Models\User');
    }
    public function cart_items(){
        return $this->hasMany('App\Models\Cart_Items');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
?>