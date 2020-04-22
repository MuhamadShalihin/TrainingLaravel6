<?php

namespace App\Http\Controllers;

use App\Mail\ProfileUpdated;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Task;
use App\User;

class ProfileController extends Controller
{
    public function getProfileView()
    {
        $user = Auth::user();

        return view('profile.view', compact('user'));
    }

    public function postProfile()
    {
        $validatedData = request()->validate([
            'name' => 'required',
            'email' => 'required | email',
            'photo' => 'image',
            'password' => 'confirmed',
        ]);

        $user = Auth::user();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = \Hash::make(request()->password);

        if(request()->has('photo'))
        {
            $path = explode('/', request()->file('photo')->store('public/profle_directory'));
            unset($path[0]);
            $publicPath = "storage/" . implode('/', $path);
            $user->photo_path = $publicPath;
        }

        $user->save();

        Mail::to($user)->send(new ProfileUpdated());

        return redirect()->back()->with('status', 'succesfully saved');
    }
}
