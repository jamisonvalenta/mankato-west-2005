<?php

namespace App\Models;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verification extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function deleted_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'deleted_by');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verified_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'verified_by');
    }

}
