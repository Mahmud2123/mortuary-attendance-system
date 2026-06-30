<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    protected $table = 'next_of_kins';

    protected $fillable = [
        'body_id',
        'full_name',
        'relationship',
        'phone',
        'email',
        'id_type',
        'id_number',
        'address',
    ];

    public function body()
    {
        return $this->belongsTo(Body::class);
    }

    public function releases()
    {
        return $this->hasMany(BodyRelease::class, 'kin_id');
    }
}