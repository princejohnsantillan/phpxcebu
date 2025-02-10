<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Participant extends Model
{
    /** @use HasFactory<\Database\Factories\ParticipantFactory> */
    use HasFactory;
    use Notifiable;

    protected $guarded = ['id', 'created_at'];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->using(EventParticipant::class);
    }
}
