<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    //Show Register/Create Form
    public function create() {
        return view('users.register');
    }
    //create new user
    public function store(Request $request) {
        $formFields =$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>['required','min:8','confirmed'],

        ]);
        //hash password

        $formFields['password'] = bcrypt($formFields['password']);

        //create user
        $user= User::create($formFields);

        //login
        auth()->login($user);

        return redirect('/')->with('message','User created and logged in');
    }
    //Logout User
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message','Logged out successfully');

    }
   //Show login form
    public function login() {
        return view('users.login');
    }

    //Authenticate user
    public function authenticate(Request $request) {
        $formFields =$request->validate([
            'email'=>['required','email'],
            'password'=>'required'
        ]);
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message','You are logged in');

        }
        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');



    }
}
