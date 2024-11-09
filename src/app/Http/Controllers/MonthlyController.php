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
            $workLists = Work::getWorkLists($userData, $thisMonth);

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
