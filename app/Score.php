<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $guarded = [];

    public function assignment()
    {
        return $this->belongsTo(Assignments::class);
    }

    public function user_from()
    {
        return $this->belongsTo(Users::class);
    }

    public function user_to()
    {
        return $this->belongsTo(Users::class);
    }

    public function section()
    {
        return $this->belongsTo(Sections::class);
    }
}
