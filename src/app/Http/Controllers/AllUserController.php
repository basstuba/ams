<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;

class AllUserController extends Controller
{
    public function index() {
        try {
            $users = User::where('id', '!=', 1)->get();

            return response()->json(['users' => $users], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }

    public function show(Request $request) {
        try {
            $userData = User::find($request->user_id);

            return response()->json(['user_data' => $userData], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }
}
