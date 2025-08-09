<?php

namespace App\Models;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    public const GALLERIES = [
        [
            'key' => 'archive',
            'title' => 'Grade/Middle/High School',
            'description' => "Experiences in school"
        ],
        [
            'key' => 'life',
            'title' => 'Your Life',
            'description' => "Life & family for you, today"
        ],
        [
            'key' => 'twenty-year',
            'title' => '20 Year Reunion',
            'description' => "Share images from this reunion!"
        ],
    ];

    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $appends = [
        'url'
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

    protected function url(): Attribute
    {
        return new Attribute(
            get: fn ($attributes) => Storage::url($this->filename),
        );
    }
}
