<?php

namespace App\Http\Controllers;

use App\Repositories\UsersRepository;
use Illuminate\Http\Request;

class SignUpController extends Controller
{

    public $userRepository;

    public function __construct(UsersRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function signUp()
    {
        return view('auth.signup');
    }

    public function signupUser(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
            'password-confirm' => 'required|same:password',
            'contact_number' => 'required',
            'designation' => 'required',
            'dob' => 'required',
            'residence' => 'required',
            'address' => 'required',
            'about' => 'required'
        ]);

        $registerUser = $this->userRepository->registerUser($request);
        if ($registerUser) {
            return redirect()->route('login')->with('message', 'You are registered successfully please wait until Admin approve your account !');
        }
    }
}
