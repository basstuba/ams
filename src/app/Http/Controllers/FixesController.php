<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Carbon\Carbon;
use Exception;

class FixesController extends Controller
{
    public function search(Request $request) {
        try {
            $searchWorkDate = Work::getWorkLists($request->user_id, $request->search_date);

            return response()->json(['search_work_date' => $searchWorkDate], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }

    public function workUpdate(Request $request) {
        try {
            $workStart = new Carbon($request->work_start);
            $workEnd = new Carbon($request->work_end);
            $laborTime = $workStart->diffInSeconds($workEnd);

            $breakTotal = $request->break_total ?? '00:00:00';
            $breakParts = explode(':', $breakTotal);
            $breakSeconds = ($breakParts[0] * 3600) + ($breakParts[1] * 60) + $breakParts[2];

            $workTime = $laborTime - $breakSeconds;
            $workTimeFormat = Work::formatTime($workTime);

            $workFixes = $request->only('work_start', 'work_end');
            $workFixes['break_total'] = $breakTotal;
            $workFixes['work_time'] = $workTimeFormat;

            Work::find($request->work_id)->update($workFixes);

            return response()->json(['message' => '勤務時間を修正しました'], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }
}
