<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Role;
use Exception;

class SelectController extends Controller
{
    public function showRole() {
        try {
            $roles = Role::all();

            return response()->json(['roles' => $roles], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }

    public function showDepartment() {
        try {
            $departments = Department::all();

            return response()->json(['departments' => $departments], 200);
        } catch(Exception $error) {
            return response()->json(['error' => 'データの取得に失敗しました'], 500);
        }
    }
}
