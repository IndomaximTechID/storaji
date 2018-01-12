<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class OrderDetail extends Model
{
    use Uuids;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'order_id',
      'product_id',
      'amount'
    ];
    
    protected $hidden = [
      'order_id',
      'product_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function product()
    {
      return $this->belongsTo('\App\Product')->withTrashed();
    }
}
