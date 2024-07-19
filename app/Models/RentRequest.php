<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class RentRequest extends Model
{

    protected $table ='requests';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    
    protected $fillable = [
        'user_id','book_id','status','returned'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
?>