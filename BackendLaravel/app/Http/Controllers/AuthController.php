<?php

namespace App\Http\Controllers;

use App\Enums\ActivitiesStatus;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	/**
	 * Create a new AuthController instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware( 'auth:api', ['except' => ['login', 'signUp']] );
	}

	/**
	 * Get a JWT token via given credentials.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @param bool $signUp
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(Request $request, $signUp = false)
	{
		$credentials = $request->only( 'email', 'password' );

		if ($token = $this->guard()->attempt( $credentials )) {
			if (!$signUp) {
				$user = User::where('id', auth()->user()->id)->first();

				$user->activity()->create([
					'user_id'  => auth()->user()->id,
					'status'   => ActivitiesStatus::USER_LOGIN,
				]);
			}

			return $this->respondWithToken( $token );
		}

		return response()->json( ['error' => 'Invalid email or password'], 401 );
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function signUp(UserRequest $request) {

		try {
			$signUp = true;
			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password)
			]);

			$user->activity()->create([
				'user_id'  => $user->id,
				'status'   => ActivitiesStatus::USER_REGISTER,
			]);

			return $this->login($request, $signUp);
		} catch (\Exception $exception) {
			$exception->getMessage();
		}
	}

	/**
	 * Get the authenticated User
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function me()
	{
		return response(new UserResource(auth()->user()));
	}

	/**
	 * Log the user out (Invalidate the token)
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout()
	{
		$user = User::where('id', auth()->user()->id)->first();

		$user->activity()->create([
			'user_id'  => auth()->user()->id,
			'status'   => ActivitiesStatus::USER_LOGOUT,
		]);

		$this->guard()->logout();

		return response()->json( ['message' => 'Successfully logged out'] );
	}

	/**
	 * Refresh a token.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh()
	{
		return $this->respondWithToken( $this->guard()->refresh() );
	}

	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken($token)
	{
		return response()->json( [
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => $this->guard()->factory()->getTTL() * 60,
			'user' => new UserResource(auth()->user()),
		] );
	}

	/**
	 * Get the guard to be used during authentication.
	 *
	 * @return \Illuminate\Contracts\Auth\Guard
	 */
	public function guard()
	{
		return Auth::guard('api');
	}
}