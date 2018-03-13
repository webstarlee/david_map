<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvalidLocation extends Model
{
    protected $table = 'invalid_locations';

    public $timestamps = false;

    protected $fillable = [
        'location_id',
        'table_name',
    ];
}
