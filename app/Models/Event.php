<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    const AUDIENCE_PUBLIC = 'public';
    const AUDIENCE_MUSLIMAH = 'muslimah';
    
    
    protected $fillable = [
        'event_name', 'date', 'start_time', 'end_time', 'event_description', 'audience_code', 'creator_id',
    ];

    public function getTimeAttribute()
    {
        $time = $this->start_time.' - ';
        $time .= !$this->end_time ? 'tamat' : $this->end_time;

        return $time;
    }

    public function getAudienceAttribute()
    {
        return __('event.audience_'.$this->audience_code);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function getDateOnlyAttribute()
    {
        return substr($this->date, -2);
    }

    public function getMonthAttribute()
    {
        return Carbon::parse($this->date)->format('m');
    }

    public function getMonthNameAttribute()
    {
        return Carbon::parse($this->date)->isoFormat('MMM');
    }

    public function getYearAttribute()
    {
        return Carbon::parse($this->date)->format('Y');
    }

    public function getDayNameAttribute(): string
    {
        if (is_null($this->date)) {
            return '';
        }

        $dayName = Carbon::parse($this->date)->isoFormat('dddd');
        if ($dayName == 'Minggu') {
            $dayName = 'Ahad';
        }

        return $dayName;
    }

    public function getFullDateAttribute()
    {
        return Carbon::parse($this->date)->isoFormat('D MMMM Y');
    }
}
