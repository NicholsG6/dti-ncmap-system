<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'full_name',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if user is guest
     */
    public function isGuest(): bool
    {
        return $this->user_type === 'guest';
    }

    /**
     * Office locations created by this user
     */
    public function officeLocations()
    {
        return $this->hasMany(OfficeLocation::class, 'created_by');
    }

    /**
     * Staff information created by this user
     */
    public function staffInformation()
    {
        return $this->hasMany(StaffInformation::class, 'created_by');
    }

    /**
     * Reminders created by this user
     */
    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'created_by');
    }
}
