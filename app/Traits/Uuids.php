<?php
namespace App\Traits;

use Webpatser\Uuid\Uuid;

trait Uuids
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($table) {
            // Generate uuid
            $table->id = Uuid::generate(4);
        });
    }
}
