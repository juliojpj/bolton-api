<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model {
    protected $table = 'nota';
    protected $fillable = ['access_key', 'value', 'created_at'];
}
