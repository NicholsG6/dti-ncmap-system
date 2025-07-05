<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_created',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'region',
        'province',
        'municipality',
        'district',
        'complete_address',
        'location_id',
        'remarks',
        'type_advanced',
        'type_code',
        'service_area',
        'contact_person',
        'position',
        'cellphone_number',
        'email_address',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'date_created' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * User who created this staff information
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Office location where this staff member works
     */
    public function officeLocation()
    {
        return $this->belongsTo(OfficeLocation::class, 'location_id');
    }

    /**
     * Reminders for this staff member
     */
    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'staff_id');
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        $fullName = $this->first_name;
        
        if ($this->middle_name) {
            $fullName .= ' ' . $this->middle_name;
        }
        
        $fullName .= ' ' . $this->last_name;
        
        return $fullName;
    }

    /**
     * Scope for active staff
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by type code
     */
    public function scopeByTypeCode($query, $typeCode)
    {
        return $query->where('type_code', $typeCode);
    }

    /**
     * Scope by province
     */
    public function scopeByProvince($query, $province)
    {
        return $query->where('province', $province);
    }
}
