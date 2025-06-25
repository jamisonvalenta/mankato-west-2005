<?php

namespace App\Models;

use App\Models\Attendee;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'show_attendance' => 'boolean',
        ];
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendees() : HasMany
    {
        return $this->hasMany(Attendee::class);
    }

    public function scopeMostRecent($query)
    {
        $query->orderBy('created_at', 'desc');
    }
}
