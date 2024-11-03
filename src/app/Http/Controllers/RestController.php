<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Work;
use Carbon\Carbon;
use Exception;

class RestController extends Controller
{
    public function store(Request $request) {
        try {
            $work = Work::getLatestWorkByUserId($request->user_id);
            $start = Work::currentTime();

            Rest::create([
                "work_id" => $work->id,
                "break_start" => $start
            ]);

            return response()->json(['message' => '休憩開始しました'], 201);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }

    public function update(Request $request) {
        try {
            $work = Work::getLatestWorkByUserId($request->user_id);
            $rest = Rest::where('work_id', $work->id)->latest()->first();

            $breakStart = new Carbon($rest->break_start);
            $breakEnd = Work::currentTime();
            $breakTotal = isset($work->break_total) ? new Carbon($work->break_total) : null;

            $breakTime = $breakStart->diffInSeconds(new Carbon($breakEnd));
            $breakTimeFormat = Work::formatTime($breakTime);

            Rest::find($rest->id)->update([
                "break_end" => $breakEnd,
                "break_time" => $breakTimeFormat
            ]);

            if($breakTotal === null) {
                $break = $breakTimeFormat;
            }else{
                $break = $breakTotal->addSeconds($breakTime);
            }

            Work::find($work->id)->update([
                "break_total" => $break
            ]);

            return response()->json(['message' => '休憩終了しました'], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }
}
