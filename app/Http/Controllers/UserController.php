<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function home() {
        $posts = [];
        if (auth()->check()) {
            $posts = auth()->user()->posts()->latest()->get();
        }
        return view('home', ['posts' => $posts]);
    }

    public function register(Request $request) {
        if (auth()->check()) {
            return 'You are already logged in.';
        }

        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:10', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/');
    }

    public function login(Request $request) {
        if (auth()->check()) {
            return 'You are already logged in.';
        }

        $incomingFields = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['name' => $incomingFields['loginname'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
        }

        return redirect('/');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }
}
