<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Carbon\Carbon;

class DailyController extends Controller
{
    public function index() {
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $dayBefore = Work::getBeforeDate($yesterday);
        $dayAfter = Work::getAfterDate($yesterday);

        $works = Work::getWorksByDate($yesterday);

        return response()->json([
            'on_the_day' => $yesterday,
            'day_before' => $dayBefore,
            'day_after' => $dayAfter,
            'works' => $works
        ], 200);
    }

    public function showBefore(Request $request) {
        $onTheDay = $request->day_before;
        $dayBefore = Work::getBeforeDate($onTheDay);
        $dayAfter = Work::getAfterDate($onTheDay);

        $works = Work::getWorksByDate($onTheDay);

        return response()->json([
            'on_the_day' => $onTheDay,
            'day_before' => $dayBefore,
            'day_after' => $dayAfter,
            'works' => $works
        ], 200);
    }

    public function showAfter(Request $request) {
        $onTheDay = $request->day_after;
        $dayBefore = Work::getBeforeDate($onTheDay);
        $dayAfter = Work::getAfterDate($onTheDay);

        $works = Work::getWorksByDate($onTheDay);

        return response()->json([
            'on_the_day' => $onTheDay,
            'day_before' => $dayBefore,
            'day_after' => $dayAfter,
            'works' => $works
        ], 200);
    }
}
