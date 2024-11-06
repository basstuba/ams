<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'work_id',
        'break_start',
        'break_end',
        'break_time',
    ];

    public function work() {
        return $this->belongsTo('App\Models\Work');
    }

    public static function getLatestRestByWorkId($workId) {
        return self::where('work_id', $workId)->latest()->first();
    }
}
