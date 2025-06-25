<?php

namespace App\Models;

use App\Http\Requests\Registration\Registration;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Attendee extends Model
{
    protected $guarded = [
        'id',
    ];

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Registration::class);
    }

    public function registration() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
