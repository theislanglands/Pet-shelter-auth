<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        $adoptions = Adoption::latest()->unadopted()->get();
        return view('adoptions.list', ['adoptions' => $adoptions, 'header' => 'Available for adoption']);
    }

    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        // validate fields
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        // logging in the user - using attempt to ensure the user exists in db
        if (auth()->attempt(['email'=> $request->email, 'password'=> $request->password])){
            // user exists- redirecting to the home route `/`
            return redirect(route('home'));
        } else {
            // user doesn't exist
            return redirect(route('login'));
        }

        /*
        |-----------------------------------------------------------------------
        | Task 3 Guest, step 5. You should implement this method as instructed
        |-----------------------------------------------------------------------
        */
    }

    public function register()
    {
        return view('register');
    }

    public function doRegister(Request $request)
    {
        {
            // validate fields
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed']
            ]);

            // create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // logging in the user
            Auth::login($user);

            // redirecting her to the right page. - the home route `/`.
            return redirect(route('home'));
        }
    }

    public function logout()
    {
        // logging out the user
        auth()->logout();

        // redirecting her to to the home page.
        return redirect(route('home'));
        /*

        |-----------------------------------------------------------------------
        | Task 2 User, step 3. You should implement this method as instructed
        |-----------------------------------------------------------------------
        */
    }
}
