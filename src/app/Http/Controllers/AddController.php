<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Carbon\Carbon;
use Exception;

class AddController extends Controller
{
    public function store(Request $request) {
        try {
            $workStart = new Carbon($request->work_start);
            $workEnd = new Carbon($request->work_end);
            $laborTime = $workStart->diffInSeconds($workEnd);

            $breakTotal = $request->break_total ?? '00:00:00';
            $breakParts = explode(':', $breakTotal);
            $breakSeconds = ($breakParts[0] * 3600) + ($breakParts[1] * 60) + $breakParts[2];

            $workTime = $laborTime - $breakSeconds;
            $workTimeFormat = Work::formatTime($workTime);

            $workAdd = $request->only(
                'user_id',
                'date',
                'work_start',
                'work_end'
            );
            $workAdd['break_total'] = $breakTotal;
            $workAdd['work_time'] = $workTimeFormat;

            Work::create($workAdd);

            return response()->json(['message'=> '勤怠を追加しました'], 201);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }
}
