<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masjid extends Model
{
    protected $fillable = [
        'name',
        'total_area',
        'capacity',
        'gate_count',
        'wing_count',
        'prayer_hall_count',
        'tawaf_per_hour',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}
