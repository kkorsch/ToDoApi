<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register( RegisterRequest $request )
    {
      $user = new User;
      $user->username = $request->username;
      $user->email = $request->email;
      $user->password = bcrypt( $request->password );

      $user->save();

      return fractal()->item( $user )->transformWith( new UserTransformer )->toArray();
    }
}
