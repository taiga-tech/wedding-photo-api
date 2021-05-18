<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'required',
            'message' => 'max:30',
            // 'files' => 'required|image',
            // 'files.*.photo' => 'required|image|mimes:jpeg,bmp,png',
            // 'aspect.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => '必須項目です。',
            'email' => 'メールアドレスの形式で入力してください。',
            'opinion.max' => '30文字以内で入力してください。',
            'image' => '画像を選択してください。',
        ];
    }
}
