<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Body extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ref_number','full_name','age','sex','nationality',
        'date_of_death','time_of_death','cause_of_death','place_of_death',
        'admitted_by','chamber_id','status','notes'
    ];

    protected $casts = ['date_of_death' => 'date'];

    public function admittedBy()    { return $this->belongsTo(User::class, 'admitted_by'); }
    public function chamber()       { return $this->belongsTo(Chamber::class); }
    public function nextOfKins()    { return $this->hasMany(NextOfKin::class); }
    public function releases()      { return $this->hasMany(BodyRelease::class); }
    public function assignments()   { return $this->hasMany(BodyChamberAssignment::class); }

    public static function generateRefNumber(): string
    {
        $year = date('Y');
        $last = static::withTrashed()->whereYear('created_at', $year)->count();
        return 'MTR-' . $year . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'admitted'    => 'warning',
            'in_storage'  => 'info',
            'released'    => 'success',
            'transferred' => 'secondary',
            default       => 'light',
        };
    }
}
