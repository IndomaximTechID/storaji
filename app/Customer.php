<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Customer extends Model
{
    use Uuids, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'full_name',
      'company_name',
      'email',
      'address',
      'postal_code',
      'city',
      'country',
      'company_id'
    ];

    public function company()
    {
      return $this->belongsTo('\App\Company');
    }

    public function order()
    {
      return $this->hasOne('\App\Order');
    }

    protected $hidden = [
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
}
