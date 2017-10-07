<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use \App\Traits\Uuids;
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
      'country'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
