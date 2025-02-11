<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventParticipant extends Pivot
{
    use Notifiable;

    protected $guarded = ['id', 'created_at'];
}
