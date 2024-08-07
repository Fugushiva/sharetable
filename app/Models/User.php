<?php

namespace App\Models;

use Cmgmyr\Messenger\Traits\Messagable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\Language;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasName
{
    use HasFactory, Notifiable, Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'firstname',
        'lastname',
        'language_id',
        'profile_picture',
        'country_id',
        'city_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(profile::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function host(): HasOne
    {
        return $this->hasOne(Host::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'reviewer_id');
    }

    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'reviewee_id');
    }

    /**
     * Check if the user has a role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->roles->contains('role', $role);
    }


    /**
     * Check if the user can acces the Filament panel.
     *
     * @param string $profile
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFilamentName(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Get evaluatiopns given by guests.
     * @return HasMany
     */
    public function guestReviewsReceived()
    {
        return $this->hasMany(Evaluation::class, 'reviewee_id')
            ->whereHas('reservation', function ($query) {
                $query->where('user_id', $this->id);
            });
    }

    public function paginatedGuestReviewsReceived($perPage)
    {
        return $this->guestReviewsReceived()->paginate($perPage);
    }

    /**
     * Get evaluations given by hosts.
     * @return HasMany
     */
    public function hostReviewsReceived()
    {
        return $this->hasMany(Evaluation::class, 'reviewee_id')->whereHas('reservation.annonce', function ($query) {
            $query->where('host_id', $this->id);
        });
    }

    /**
     * Check if the user is a guest.
     * @return bool
     */
    public function isGuest()
    {
        return $this->profiles()->where('profile', 'guest')->exists();
    }

    /**
     * Check if the user is a host.
     * @return bool
     */
    public function isHost()
    {
        return $this->profiles()->where('profile', 'host')->exists();
    }

}
