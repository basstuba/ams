<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\UsersImport;

class ImportController extends Controller
{
    public function import(Request $request) {
        try {
            Excel::import(new UsersImport, $request->file('file'), null, \Maatwebsite\Excel\Excel::CSV);

            return response()->json(['message' => '登録完了しました'], 200);
        } catch(ValidationException $error) {
            $failures = $error->failures();

            return response()->json([
                'message' => 'インポートエラーが発生しました',
                'errors' => collect($failures)->map(function ($failure) {
                    return [
                        'row' => $failure->row(),
                        'attribute' => $failure->attribute(),
                        'errors' => $failure->errors(),
                        'values' => $failure->values(),
                    ];
                }),
            ], 422);
        }
    }
}
