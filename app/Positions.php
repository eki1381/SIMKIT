<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{

    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Sections::class);
    }
}
