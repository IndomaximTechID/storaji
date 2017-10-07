<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \App\Traits\Uuids;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'customer_id'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function customer()
    {
      return $this->belongsTo('\App\Customer');
    }

    public function order_detail()
    {
      return $this->hasOne('\App\OrderDetail');
    }
}
