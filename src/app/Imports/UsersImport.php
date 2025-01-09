<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel,WithHeadingRow,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name' => $row['氏名'],
            'email' => $row['メールアドレス'],
            'password' => Hash::make($row['パスワード']),
            'role' => $row['社員区分'],
            'number' => $row['社員番号'],
            'department' => $row['所属部門']
        ]);
    }

    public function rules(): array
    {
        return [
            '氏名' => 'required|max:20',
            'メールアドレス' => 'required|email|unique:users,email',
            'パスワード' => 'required|min:8',
            '社員区分' => 'required|in:社員,契約社員,アルバイト',
            '社員番号' => ['required', 'regex:/^\d{5}$/'],
            '所属部門' => 'required|in:総務部,人事部,経理部,営業部,開発部,無し'
        ];
    }

    public function customValidationMessages()
    {
        return [
            '氏名.required' => '氏名がありません',
            '氏名.max' => '氏名は20文字以内にしてください',
            'メールアドレス.required' => 'メールアドレスがありません',
            'メールアドレス.email' => 'メールアドレスは有効なメールアドレス形式で入力してください',
            'メールアドレス.unique' => 'このメールアドレスは既に使用されています',
            'パスワード.required' => 'パスワードがありません',
            'パスワード.min' => 'パスワードは8文字以上にしてください',
            '社員区分.required' => '社員区分がありません',
            '社員区分.in' => '社員区分は「社員」「契約社員」「アルバイト」のいずれかにしてください',
            '社員番号.required' => '社員番号がありません',
            '社員番号.regex' => '社員番号は5桁の数字にしてください',
            '所属部門.required' => '所属部門がありません',
            '所属部門.in' => '所属部門は「総務部」「人事部」「経理部」「営業部」「開発部」「無し」のいずれかにしてください'
        ];
    }
}
