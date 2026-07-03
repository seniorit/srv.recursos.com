<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\RequestImplement;

class LoginRequest extends RequestImplement
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'username' => ['required_without:email', 'string', 'min:1', 'max:50'],
      'email' => ['required_without:username', 'email', 'max:100'],
      'password' => ['required', 'string', 'min:8'],
    ];
  }
}
