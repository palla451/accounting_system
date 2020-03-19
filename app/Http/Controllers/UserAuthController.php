<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use function GuzzleHttp\Promise\all;

class UserAuthController extends Controller
{
    public function index()
    {
        return view('user.login');
    }

    public function login()
    {
        return view('user.login');
    }

    public function register()
    {
        $jobs = Job::all();

        return view('user.register', ['jobs' => $jobs]);
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials))
        {
            $user = Auth::user();
            //Passed authentication...
            return redirect()->route('inputs.index');
        }
        else
           return Redirect::to('login')->withFail('Ops! username o password errate!');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'fstName' => 'required',
            'lstName' => 'required',
            'job_id' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return Redirect::to("login")->withSuccess('Grazie per la tua registrazione!! Ora puoi effettuare il login.');
    }

    public function dashboard()
    {
        if(Auth::check())
            return view('layout.dashboard');
        else
         return Redirect::to("login")->withFail('Non hai accesso a questa pagina!');
    }

    public function create($data)
    {
        $user = User::create([
            'fstName' => $data['fstName'],
            'lstName' => $data['lstName'],
            'email'   => $data['email'],
            'job_id'   => $data['job_id'],
            'password' => Hash::make($data['password'])
        ]);

        $role = Role::find(1); // ruolo user
        $user->roles()->attach($role->getAttribute('id'));

        return $user;
    }


    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect::to('login');
    }
}
