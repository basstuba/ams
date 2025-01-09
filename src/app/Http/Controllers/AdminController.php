<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class AdminController extends Controller
{
    public function store(Request $request) {
        try {
            User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => $request->role,
                "number" => $request->number,
                "department" => $request->department
            ]);

            return response()->json(['message' => '登録完了しました'], 201);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }

    public function update(Request $request) {
        try {
            $user = $request->only('email', 'role', 'department');
            if(!empty($request->password)) {
                $user['password'] = Hash::make($request->password);
            }

            User::find($request->id)->update($user);

            return response()->json(['message' => '変更完了しました'], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'サーバーエラーが発生しました'], 500);
        }
    }

    public function search(Request $request) {
        try {
            $searchData = User::where('number', $request->number)->first();

            return response()->json(['search_data' => $searchData], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }
}
