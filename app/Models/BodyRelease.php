<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BodyRelease extends Model {
    protected $fillable = ['body_id','released_by','kin_id','release_date','notes'];
    protected $casts = ['release_date' => 'date'];
    public function body()       { return $this->belongsTo(Body::class); }
    public function releasedBy() { return $this->belongsTo(User::class, 'released_by'); }
    public function kin()        { return $this->belongsTo(NextOfKin::class, 'kin_id'); }
}
