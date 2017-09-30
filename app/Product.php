<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \App\Traits\Uuids;
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
      'selling_price'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $hidden = [
      'type_id'
    ];

    public function type()
    {
      return $this->belongsTo('\App\ProductType');
    }
}
