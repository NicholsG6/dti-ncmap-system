<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_name',
        'office_code',
        'latitude',
        'longitude',
        'complete_address',
        'region',
        'province',
        'municipality',
        'district',
        'contact_number',
        'email_address',
        'office_head',
        'office_description',
        'service_hours',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * User who created this office location
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Staff members at this location
     */
    public function staffMembers()
    {
        return $this->hasMany(StaffInformation::class, 'location_id');
    }

    /**
     * Reminders for this location
     */
    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'location_id');
    }

    /**
     * Get active staff members
     */
    public function activeStaffMembers()
    {
        return $this->hasMany(StaffInformation::class, 'location_id')->where('is_active', true);
    }

    /**
     * Scope for active locations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        return $this->office_name . ' (' . $this->office_code . ')';
    }
}
