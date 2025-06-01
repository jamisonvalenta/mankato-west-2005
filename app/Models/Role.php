<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
