<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    protected $guarded = [];

    public function score()
    {
        return $this->hasOne(SectionScore::class, 'section_id');
    }
}
