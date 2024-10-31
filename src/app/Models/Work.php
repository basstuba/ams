<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'date',
        'work_start',
        'work_end',
        'break_total',
        'work_time',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function rests() {
        return $this->hasMany('App\Models\Rest');
    }
}
