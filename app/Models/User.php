<?php

namespace App\Models;

use App\Models\Attendee;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Verification;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, MustVerifyEmail, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'registration',
        'roles',
        'can_see_admin_dashboard',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }

    public function registrations() : HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function roles() : HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function payments() : HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function verifications() : HasMany
    {
        return $this->hasMany(Verification::class);
    }

    protected function getRolesAttribute(): Attribute
    {
        return new Attribute(
            get: fn () => $this->roles()->pluck('type'),
        );
    }

    protected function registration(): Attribute
    {
        return new Attribute(
            get: fn () => $this->registrations()->orderBy('id', 'desc')->first(),
        );
    }

    protected function canSeeAdminDashboard(): Attribute
    {
        return new Attribute(
            get: fn () => $this->can('admin')
                || $this->can('super-admin')
                || $this->can('verify'),
        );
    }
}
