<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Sections::class);
    }
}
