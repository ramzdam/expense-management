<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\UserRole;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
    public function __construct()
    {
        $this->middleware('guest');
    }

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
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'p_id' => Str::uuid(),
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'work' => $data['work'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $userRole = UserRole::create([
            'p_id' => Str::uuid(),
            'role_id' => UserRole::USER,
            'user_id' => $user->id,
            'can_create_user' => false,
            'can_update_user' => false,
            'can_delete_user' => false,
            'can_create_expense' => true,
            'can_update_expense' => true,
            'can_delete_expense' => true,
            'can_create_expense_category' => false,
            'can_update_expense_category' => false,
            'can_delete_expense_category' => false,
            'can_view_user_management' => false,
            'can_change_password' => true,
        ]);

        return $user;
    }
}
