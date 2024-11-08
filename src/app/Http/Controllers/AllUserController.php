<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AllUserController extends Controller
{
    public function index() {
        $users = User::where('id', '!=', 1)->get();

        return response()->json(['users' => $users], 200);
    }
}
