<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Thomasjohnkane\Snooze\Traits\SnoozeNotifiable;

class Assignments extends Model
{
    use Notifiable;
    use SnoozeNotifiable;
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Sections::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activities::class);
    }

    public function user_from()
    {
        return $this->belongsTo(User::class);
    }

    public function user_to()
    {
        return $this->belongsTo(User::class);
    }
}
