<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\LogController as Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Log $log, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'telephone' => 'required|max:11',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        if ($request->input('password') == $request->input('password_confirmation')) {
            $admin = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'telephone' => $request->input('telephone'),
                'password' => bcrypt($request->input('password')),
                'is_admin' => 1
            ]);
        }
        
        $action = "Created New Admin User";
        $description = "Admin User ". $admin->name . " has been Created";
        $userId = Auth::user()->id;
        
        $admin->save();

        $log->store($action, $description, $userId);

        return redirect()->back()->with("status", "$admin->name has been created as an Admin.");
    }

    public function create()
    {
        $admins = User::all()->where('is_admin', 1);

        return view('admin-users.index', compact('admins'));
    }

    //Method to detele Category
    public function delete(Log $log, $id)
    {
        $admin = User::where('id', $id)->firstOrFail();
    
        $action = "Deleted Admin User";
        $description = "Admin User ". $admin->name . " has been deleted";
        $userId = Auth::user()->id;
        
        $admin->delete();

        $log->store($action, $description, $userId);

        return redirect()->back()->with("status", "Admin Deleted.");
    }
}
