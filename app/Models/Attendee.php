<?php

namespace App\Models;

use App\Http\Requests\Registration\Registration;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Attendee extends Model
{
    protected $guarded = [
        'id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
