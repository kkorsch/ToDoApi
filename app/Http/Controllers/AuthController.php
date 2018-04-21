<?php

namespace App\Http\Controllers;

use JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Exceptions\JWTException;

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

    public function signIn( Request $request )
    {
      try {
        $token = JWTAuth::attempt( $request->only('email', 'password'), [
          'exp' => Carbon::now()->addHour()->timestamp,
        ]);
      } catch ( JWTException $e ) {
        return response()->json([
          'message' => 'Could not authenticate',
        ], 500 );
      }

      if ( !$token ) {
        return response()->json([
          'message' => 'Could not authenticate',
        ], 401 );
      }

      return fractal()
              ->item( $request->user() )
              ->transformWith( new UserTransformer )
              ->addMeta([
                'token' => $token,
              ])
              ->toArray();
    }
}
