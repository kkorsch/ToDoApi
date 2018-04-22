<?php

namespace App\Http\Controllers;

use JWTAuth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\TaskList;
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

      $taskList = new TaskList;
      $taskList->name = 'Default List';
      $user->taskLists()->save( $taskList );

      return fractal()->item( $user )->transformWith( new UserTransformer )->toArray();
    }

    public function signIn( Request $request )
    {
      $exp = Carbon::now()->addHour()->timestamp;

      try {
        $token = JWTAuth::attempt( $request->only('email', 'password'), [
          'exp' => $exp,
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
                'expiry_at' => $exp,
              ])
              ->toArray();
    }
}
