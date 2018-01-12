<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Order extends Model
{
    use Uuids;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'customer_id',
      'company_id'
    ];
    
    protected $hidden = [
      'customer_id',
      'company_id'
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

    public function customer()
    {
      return $this->belongsTo('\App\Customer')->withTrashed();
    }

    public function order_detail()
    {
      return $this->hasOne('\App\OrderDetail');
    }

    public function company()
    {
      return $this->belongsTo('\App\Company');
    }
}
