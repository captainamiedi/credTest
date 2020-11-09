<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
      'user_id',
      'amount',
      'balance',
        'account_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'float'
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\account', 'account_id');
    }
}
