<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordSubmitRequest extends FormRequest
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

    public function rules()
    {
        return [
            'email'                 => 'required|email|exists:users,email',
            'token'                 => 'required|string|exists:password_reset_tokens,token',
            'password'              => [
                'required', 'string', 'confirmed', 'min:8',
            ],
            'password_confirmation' => 'required',
        ];
    }
}
