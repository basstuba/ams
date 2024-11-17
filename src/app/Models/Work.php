<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public static function getLatestWorkByUserId($userId) {
        return self::where('user_id', $userId)->latest()->first();
    }

    public static function today() {
        return Carbon::now()->format('Y-m-d');
    }

    public static function currentTime() {
        return Carbon::now()->format('H:i:s');
    }

    public static function formatTime($timeInSeconds) {
        $hours = floor($timeInSeconds / 3600);
        $minutes = floor(($timeInSeconds % 3600) / 60);
        $seconds = $timeInSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public static function getWorksByDate($day) {
        return self::with(['user', 'rests'])->where('date', $day)->get();
    }

    public static function getBeforeDate($baseDate) {
        $subBase = new Carbon($baseDate);

        return $subBase->subDay()->format('Y-m-d');
    }

    public static function getAfterDate($baseDate) {
        $addBase = new Carbon($baseDate);

        return $addBase->addDay()->format('Y-m-d');
    }

    public static function getWorkLists($userId, $dateMonth) {
        return self::with('rests')
            ->where('user_id', $userId)
            ->where('date', 'like', '%' . $dateMonth . '%')
            ->oldest('date')
            ->get();
    }

    public static function getBeforeMonth($baseMonth) {
        $subBaseMonth = new Carbon($baseMonth);

        return $subBaseMonth->subMonth()->format('Y-m');
    }

    public static function getAfterMonth($baseMonth) {
        $addBaseMonth = new Carbon($baseMonth);

        return $addBaseMonth->addMonth()->format('Y-m');
    }
}
