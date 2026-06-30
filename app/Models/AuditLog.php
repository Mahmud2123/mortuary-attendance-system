<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model {
    protected $fillable = ['user_id','action','table_name','record_id','old_data','new_data','ip_address'];
    protected $casts = ['old_data' => 'array', 'new_data' => 'array'];
    public function user() { return $this->belongsTo(User::class); }

    public static function record(string $action, string $table, int $recordId, $old = null, $new = null): void {
        static::create([
            'user_id'    => auth()->id(),
            'action'     => $action,
            'table_name' => $table,
            'record_id'  => $recordId,
            'old_data'   => $old,
            'new_data'   => $new,
            'ip_address' => request()->ip(),
        ]);
    }
}
