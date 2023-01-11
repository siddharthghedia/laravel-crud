<?php

namespace App\Http\Requests;

use App\Models\User;

class UserRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'avatar' => 'required|image|max:2000',
            'active' => 'required|boolean',
            'gender' => 'required|in:'.User::MALE.','.User::FEMALE
        ];
    }
}
