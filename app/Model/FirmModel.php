<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FirmModel extends Model
{
    //
    protected $table="firm";
    public $timestamps = false;
    protected $primaryKey="f_id";
}
