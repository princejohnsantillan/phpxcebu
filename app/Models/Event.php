<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'day' => Carbon::parse($this->starts_at)->format('l, jS \\of F Y'),
                'time' => Carbon::parse($this->starts_at)->format('h:i A') . ' - ' . Carbon::parse($this->ends_at)->format('h:i A'),
            ],
        );
    }
}
