<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table1 extends Model
{
    protected $table = 'V_ECO_COMERCIALIZADORES';

    public $timestamps = false;

    public function getTableName()
    {
        return $this->table;
    }
}
