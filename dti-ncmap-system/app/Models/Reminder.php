<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'reminder_date',
        'reminder_time',
        'priority',
        'status',
        'location_id',
        'staff_id',
        'created_by',
    ];

    protected $casts = [
        'reminder_date' => 'date',
    ];

    /**
     * User who created this reminder
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Associated office location
     */
    public function officeLocation()
    {
        return $this->belongsTo(OfficeLocation::class, 'location_id');
    }

    /**
     * Associated staff member
     */
    public function staffMember()
    {
        return $this->belongsTo(StaffInformation::class, 'staff_id');
    }

    /**
     * Scope for active reminders
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * Scope for high priority reminders
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'High');
    }

    /**
     * Scope for upcoming reminders
     */
    public function scopeUpcoming($query)
    {
        return $query->where('reminder_date', '>=', Carbon::today())
                    ->where('status', 'Active')
                    ->orderBy('reminder_date')
                    ->orderBy('reminder_time');
    }

    /**
     * Scope for today's reminders
     */
    public function scopeToday($query)
    {
        return $query->where('reminder_date', Carbon::today())
                    ->where('status', 'Active');
    }

    /**
     * Get reminder date time
     */
    public function getReminderDateTimeAttribute()
    {
        // First check if reminder_date exists
        if (!$this->reminder_date) {
            return null;
        }

        if ($this->reminder_time) {
            // Handle reminder_date whether it's a Carbon object or string
            if ($this->reminder_date instanceof Carbon) {
                $dateStr = $this->reminder_date->format('Y-m-d');
            } else {
                $dateStr = $this->reminder_date; // Already a string
            }
            
            // reminder_time is stored as TIME in database, so it should be a string like "14:30:00"
            $timeStr = $this->reminder_time;
            
            try {
                return Carbon::parse($dateStr . ' ' . $timeStr);
            } catch (\Exception $e) {
                // If parsing fails, return just the date
                return $this->reminder_date instanceof Carbon ? $this->reminder_date : Carbon::parse($this->reminder_date);
            }
        }
        
        // Return reminder_date as Carbon object, handle null/empty cases
        if ($this->reminder_date instanceof Carbon) {
            return $this->reminder_date;
        }
        
        try {
            return Carbon::parse($this->reminder_date);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Set reminder time attribute - ensure it's in H:i:s format
     */
    public function setReminderTimeAttribute($value)
    {
        if ($value) {
            // If it's HH:MM format, add seconds
            if (preg_match('/^\d{2}:\d{2}$/', $value)) {
                $this->attributes['reminder_time'] = $value . ':00';
            } 
            // If it's already HH:MM:SS, keep it
            elseif (preg_match('/^\d{2}:\d{2}:\d{2}$/', $value)) {
                $this->attributes['reminder_time'] = $value;
            } 
            // Try to parse other formats
            else {
                try {
                    $time = Carbon::parse($value);
                    $this->attributes['reminder_time'] = $time->format('H:i:s');
                } catch (\Exception $e) {
                    $this->attributes['reminder_time'] = null;
                }
            }
        } else {
            $this->attributes['reminder_time'] = null;
        }
    }

    /**
     * Get reminder time in H:i format for HTML time inputs
     */
    public function getReminderTimeInputAttribute()
    {
        if ($this->reminder_time && is_string($this->reminder_time) && strlen($this->reminder_time) >= 5) {
            return substr($this->reminder_time, 0, 5); // Convert "14:30:00" to "14:30"
        }
        return null;
    }

    /**
     * Check if reminder is overdue
     */
    public function getIsOverdueAttribute()
    {
        $reminderDateTime = $this->reminder_date_time;
        
        if (!$reminderDateTime) {
            return false; // Can't be overdue if no valid date/time
        }
        
        return $reminderDateTime < Carbon::now() && $this->status === 'Active';
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'High' => 'danger',
            'Medium' => 'warning',
            'Low' => 'info',
            default => 'secondary'
        };
    }
}
