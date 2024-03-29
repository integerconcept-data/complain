<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create()
    {
        $oldTelephone = Auth::user()->telephone;

        return view('settings.index', compact('oldTelephone'));
    }

    public function updateTelephone(Request $request)
    {
        $this->validate($request, [
            'telephone'     => 'required|max:11',
        ]);

        $user = User::find(Auth::user()->id);

        $user->telephone = $request->input('telephone');

        $user->save();

        return redirect()->back()->with("status", "Your Telephone Number has been submitted.");
    }
}
