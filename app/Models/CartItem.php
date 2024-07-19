<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function carts(){
        return $this->belongsTo('App\Models\Cart');
    }
    public function books(){
        return $this->belongsTo('App\Models\Book');
    }
    protected $fillable = [
        'cart_id','book_id','quantity'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
?>