<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;
    use HasUuids;

    protected $guarded = ['id', 'created_at'];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }


    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(Participant::class)->using(EventParticipant::class);
    }
}
