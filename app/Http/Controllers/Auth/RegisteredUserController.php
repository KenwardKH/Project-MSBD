<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        if (Auth::check()) {
            // Redirect based on the user's role
            if (Auth::user()->role === 'kasir') {
                return redirect()->route('kasir.home');
            } elseif (Auth::user()->role === 'pemilik') {
                return redirect()->route('owner.home');
            } else {
                return redirect('/pengguna/home');
            }
        }

        return view('auth.register');
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255', // validation for address
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Create the User
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        // Kirim email verifikasi setelah user dibuat
        $user->sendEmailVerificationNotification();

        // Create the associated Customer record with name, nomor_telepon, and address
        Customer::create([
            'user_id' => $user->id,
            'CustomerName' => $request->name,
            'CustomerContact' => $request->nomor_telepon,
            'CustomerAddress' => $request->alamat, // store address as CustomerAddress
        ]);

        // Log the user in and redirect to their intended destination
        Auth::login($user);

        return redirect()->route('pengguna.home');
    }
}
