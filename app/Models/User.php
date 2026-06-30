<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['full_name', 'staff_id', 'email', 'password', 'role', 'status'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function isAdmin(): bool        { return $this->role === 'admin'; }
    public function isAttendant(): bool    { return $this->role === 'attendant'; }
    public function isManagement(): bool   { return $this->role === 'management'; }

    public function bodies()        { return $this->hasMany(Body::class, 'admitted_by'); }
    public function attendanceLogs(){ return $this->hasMany(AttendanceLog::class, 'staff_id'); }
    public function releases()      { return $this->hasMany(BodyRelease::class, 'released_by'); }

    public function currentAttendance()
    {
        return $this->attendanceLogs()->whereNull('clock_out')->latest()->first();
    }
}
