<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Participant extends Model
{
    /** @use HasFactory<\Database\Factories\ParticipantFactory> */
    use HasFactory;

    protected $guarded = ['id', 'created_at'];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->using(EventParticipant::class);
    }
}
