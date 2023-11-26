<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UsersRepository;

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
        // dd($request->all());
        $validatedData = $request->validate([
            'full_name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
            'password-confirm' => 'required|same:password',
            'contact_number' => 'required',
            'designation' => 'required',
            'dob' => 'required',
            'district' => 'required',
            'village_council' => 'required',
            'tehsil' => 'required',
            'candidate_name' => 'required',
            'constituency' => 'required'

        ]);

        $registerUser = $this->userRepository->registerUser($request);
        Auth::loginUsingId($registerUser->id);
        return redirect()->route('users.dashboard')->with('message', 'You are registered successfully please wait until Admin approve your account !');
    }
}
