<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BodyChamberAssignment extends Model {
    protected $fillable = ['body_id','chamber_id','assigned_at','vacated_at'];
    protected $casts = ['assigned_at' => 'datetime', 'vacated_at' => 'datetime'];
    public function body()    { return $this->belongsTo(Body::class); }
    public function chamber() { return $this->belongsTo(Chamber::class); }
}
