<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Mockery\Exception;

class ShowProfile extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function __invoke($id)
    {
        if(Auth::user()->id == $id)
            return view('user.profile', ['user' => User::findOrFail($id)]);

        else
            return redirect()->route('myProfile', ['id' => Auth::user()->id])->with('fail','non puoi vedere il profilo degli altri');

    }
}
