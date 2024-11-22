<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Work;
use Carbon\Carbon;
use Exception;

class FixesController extends Controller
{
    public function search(Request $request) {
        try {
            $searchWorkData = Work::getWorkLists($request->user_id, $request->search_date);

            return response()->json(['search_work_data' => $searchWorkData], 200);
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

    public function restUpdate(Request $request) {
        try {
            $breakStart = new Carbon($request->break_start);
            $breakEnd = new Carbon($request->break_end);
            $breakTime = $breakStart->diffInSeconds($breakEnd);
            $breakTimeFormat = Work::formatTime($breakTime);

            $restFixes = $request->only('break_start', 'break_end');
            $restFixes['break_time'] = $breakTimeFormat;

            Rest::find($request->rest_id)->update($restFixes);

            $newRest = Rest::find($request->rest_id);
            $workFixes = Work::find($newRest->work_id);
            $breakTimes = Rest::where('work_id', $workFixes->id)->select('break_time')->get();

            $breakTotal = $breakTimes->reduce(function ($carry, $item) {
                list($hours, $minutes, $seconds) = explode(':', $item->break_time);
                $carry += $hours * 3600 + $minutes * 60 + $seconds;
                return $carry;
            }, 0);
            $breakTotalFormat = Work::formatTime($breakTotal);

            Work::find($workFixes->id)->update(['break_total' => $breakTotalFormat]);

            return response()->json(['message' => '休憩時間を修正しました'], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }
}
