<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $admin = DB::table('admins')
            ->where('username', $request->username)
            ->first();

        if(!$admin){
            return back()->with('error','Invalid credentials');
        }

        if(!Hash::check($request->password, $admin->password)){
            return back()->with('error','Invalid credentials');
        }

        session([
            'admin_logged' => true,
            'admin_id' => $admin->id,
            'admin_username' => $admin->username
        ]);

        return redirect('admin');
    }
}
