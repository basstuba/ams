<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Exception;

class MonthlyController extends Controller
{
    public function index(Request $request) {
        try {
            $thisMonth = Carbon::today()->format('Y-m');
            $monthBefore = Work::getBeforeMonth($thisMonth);
            $monthAfter = Work::getAfterMonth($thisMonth);

            $userData = User::find($request->user_id);
            $workLists = Work::getWorkLists($request->user_id, $thisMonth);

            return response()->json([
                'this_month' => $thisMonth,
                'month_before' => $monthBefore,
                'month_after' => $monthAfter,
                'user_data' => $userData,
                'work_lists' => $workLists
            ], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }

    public function showBefore(Request $request) {
        try {
            $thisMonth = $request->month_before;
            $monthBefore = Work::getBeforeMonth($thisMonth);
            $monthAfter = Work::getAfterMonth($thisMonth);

            $userData = User::find($request->user_id);
            $workLists = Work::getWorkLists($request->user_id, $thisMonth);

            return response()->json([
                'this_month' => $thisMonth,
                'month_before' => $monthBefore,
                'month_after' => $monthAfter,
                'user_data' => $userData,
                'work_lists' => $workLists
            ], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }

    public function showAfter(Request $request) {
        try {
            $thisMonth = $request->month_after;
            $monthBefore = Work::getBeforeMonth($thisMonth);
            $monthAfter = Work::getAfterMonth($thisMonth);

            $userData = User::find($request->user_id);
            $workLists = Work::getWorkLists($request->user_id, $thisMonth);

            return response()->json([
                'this_month' => $thisMonth,
                'month_before' => $monthBefore,
                'month_after' => $monthAfter,
                'user_data' => $userData,
                'work_lists' => $workLists
            ], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }

    public function search(Request $request) {
        try {
            $thisMonth = $request->date_month;
            $monthBefore = Work::getBeforeMonth($thisMonth);
            $monthAfter = Work::getAfterMonth($thisMonth);

            $userData = User::find($request->user_id);
            $workLists = Work::getWorkLists($request->user_id, $thisMonth);

            return response()->json([
                'this_month' => $thisMonth,
                'month_before' => $monthBefore,
                'month_after' => $monthAfter,
                'user_data' => $userData,
                'work_lists' => $workLists
            ], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }
}
