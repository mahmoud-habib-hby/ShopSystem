<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    // صفحة تسجيل الدخول
    public function showLoginForm()
    {
        return view('login.login');
    }

    // عملية تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // التوجيه حسب الدور
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('product.index');
            if ($role === 'delivery') return redirect()->route('delivery.index');
            return redirect()->route('customer.index'); 
        }

        return back()->with('error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة');
    }

    // صفحة تسجيل مستخدم جديد
    public function showRegisterForm()
    {
        return view('login.register');
    }

    // حفظ المستخدم الجديد
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
            // 'role' => 'required|in:admin,delivery,customer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        Auth::login($user); 

        return redirect()->route('customer.index');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}