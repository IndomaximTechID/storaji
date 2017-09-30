<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use \App\Traits\Uuids;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
