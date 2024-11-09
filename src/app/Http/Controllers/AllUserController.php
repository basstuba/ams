<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
