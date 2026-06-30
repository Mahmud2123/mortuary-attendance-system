<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model {
    protected $fillable = ['staff_id','clock_in','clock_out','duration_hours','notes'];
    protected $casts = ['clock_in' => 'datetime', 'clock_out' => 'datetime'];
    public function staff() { return $this->belongsTo(User::class, 'staff_id'); }
    public function isActive(): bool { return is_null($this->clock_out); }
}
