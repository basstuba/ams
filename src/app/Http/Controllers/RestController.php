<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Work;
use Carbon\Carbon;
use Exception;

class RestController extends Controller
{
    public function index(Request $request) {
        $work = Work::getLatestWorkByUserId($request->user_id);
        $rest = ( !$work ) ? ['break_start' => '', 'break_end' => ''] : Rest::getLatestRestByWorkId($work->id);

        return response()->json(['rest' => $rest], 200);
    }

    public function store(Request $request) {
        try {
            $work = Work::getLatestWorkByUserId($request->user_id);
            $start = Work::currentTime();

            $rest = Rest::create([
                "work_id" => $work->id,
                "break_start" => $start
            ]);

            $newRest = Rest::find($rest->id);

            return response()->json(['message' => '休憩開始しました', 'rest' => $newRest], 201);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }

    public function update(Request $request) {
        try {
            $work = Work::getLatestWorkByUserId($request->user_id);
            $rest = Rest::getLatestRestByWorkId($work->id);

            $breakStart = new Carbon($rest->break_start);
            $breakEnd = Work::currentTime();
            $breakTotal = isset($work->break_total) ? new Carbon($work->break_total) : null;

            $breakTime = $breakStart->diffInSeconds(new Carbon($breakEnd));
            $breakTimeFormat = Work::formatTime($breakTime);

            Rest::find($rest->id)->update([
                "break_end" => $breakEnd,
                "break_time" => $breakTimeFormat
            ]);

            $newRest = Rest::find($rest->id);

            if($breakTotal === null) {
                $break = $breakTimeFormat;
            }else{
                $break = $breakTotal->addSeconds($breakTime);
            }

            Work::find($work->id)->update([
                "break_total" => $break
            ]);

            return response()->json(['message' => '休憩終了しました', 'rest' => $newRest], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }
}
