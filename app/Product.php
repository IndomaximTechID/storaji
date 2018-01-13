<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use DB;

class Product extends Model
{
    use Uuids, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'sku',
      'name',
      'description',
      'type_id',
      'stock',
      'cost',
      'selling_price',
      'image',
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

    protected $hidden = [
      'type_id',
      'company_id'
    ];

    public function type()
    {
      return $this->belongsTo('\App\ProductType');
    }

    public function company()
    {
      return $this->belongsTo('\App\Company');
    }

    public function sold()
    {
      return $this->hasOne('App\OrderDetail')
                  ->select(DB::raw('product_id, sum(amount) as amount'))
                  ->groupBy('product_id');
    }
}
