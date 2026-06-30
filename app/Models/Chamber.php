<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chamber extends Model
{
    protected $fillable = ['name', 'location', 'capacity', 'current_occupancy', 'status', 'notes'];

    public function bodies()      { return $this->hasMany(Body::class); }
    public function assignments() { return $this->hasMany(BodyChamberAssignment::class); }

    public function getAvailableSlots(): int
    {
        return max(0, $this->capacity - $this->current_occupancy);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'available'   => 'success',
            'full'        => 'danger',
            'maintenance' => 'warning',
            default       => 'secondary',
        };
    }

    public function getOccupancyPercentAttribute(): int
    {
        if ($this->capacity === 0) return 0;
        return (int) round(($this->current_occupancy / $this->capacity) * 100);
    }
}
