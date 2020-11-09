<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\accountController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\walletController;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest');
//    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {
        $referrer = User::where('email', $request->ref)->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'referrer_id' => $referrer ? $referrer->id : null,
            'password' => Hash::make($request->password),
        ]);
        $account = new accountController();
        $account->create($user);
        if ($referrer) {
            $acc = $account->getUserAccount($referrer->id);
            $wallet = new walletController();
            $wallet->creditUserWithReferrer($referrer, $acc);
        }
        $token = $user->createToken('my-app')->accessToken;
        return response()->json([
           'token' => $token
        ], 201);
    }

    public function checkReferral(Request $request )
    {
        if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }

        return response()->json([

        ], 200);
//        return redirect::to('/login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return \response()->json(['error' => 'user does not exist'], 409);
        }
        if (!Hash::check(request()->password, $user->password)) {
            return response()->json(['error' => 'Password is not correct'], 401);
        }

        $token = $user->createToken('my-app')->accessToken;

        return \response()->json([
           'token' => $token
        ], 200);
    }
}
