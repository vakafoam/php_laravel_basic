<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class SigninController extends Controller
{
    public function signin(Request $request) 
    {
        // dd("Our custom auth controller");    
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(Auth::attempt(
                [
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ], $request->has('remember'))) 
        {
            // return redirect('/admin');
            return redirect()->route('admin.index'); // the same as above line
        }
        return redirect()->back()->with('fail', 'Authentication failed');
    }
}
