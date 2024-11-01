<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Carbon\Carbon;
use Exception;

class WorkController extends Controller
{
    public function store(Request $request) {
        try {
            $today = Work::today();
            $start = Work::currentTime();

            Work::create([
                "user_id" => $request->user_id,
                "date" => $today,
                "work_start" => $start
            ]);

            return response()->json(['message' => '勤務開始しました'], 201);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }

    public function update(Request $request) {
        try {
            $work = Work::where('user_id', $request->user_id)->latest()->first();

            $laborStart = new Carbon($work['work_start']);
            $laborEnd = Work::currentTime();
            $breakTime = isset($work['break_total']) ? new Carbon($work['break_total']) : null;

            $laborTime = $laborStart->diffInSeconds(new Carbon($laborEnd));
            $laborTimeFormat = Work::formatTime($laborTime);

            if($breakTime == null) {
                $workTotal = $laborTimeFormat;
            }else{
                $workTime = $breakTime->diffInSeconds($laborTimeFormat);
                $workTotal = Work::formatTime($workTime);
            }

            Work::find($work->id)->update([
                "work_end" => $laborEnd,
                "work_time" => $workTotal
            ]);

            return response()->json(['message' => '勤務終了です。お疲れ様でした'], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }
}
