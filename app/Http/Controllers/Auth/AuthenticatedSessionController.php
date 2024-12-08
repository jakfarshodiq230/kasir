<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Periksa status_user
        if ($request->user()->status_user != 1) {
            Auth::logout(); // Logout pengguna jika status_user tidak valid
            return redirect()->route('login')->withErrors([
                'status_user' => 'Akun Anda belum aktif. Silakan hubungi administrator.',
            ]);
        }

        $cabang = $request->user()->cabang;
        $toko = $request->user()->toko;
        $gudang = $request->user()->gudang;

        if ($cabang) {
            $request->session()->put('cabang_id', $cabang->id);
            $request->session()->put('cabang_nama', $cabang->nama_toko_cabang);
        }
        if ($toko) {
            $request->session()->put('toko_id', $toko->id);
            $request->session()->put('toko_nama', $toko->nama_toko);
        }
        if ($gudang) {
            $request->session()->put('gudang_id', $gudang->id);
            $request->session()->put('gudang_nama', $gudang->nama_gudang);
        }

        if (Auth::check()) {
            switch (Auth::user()->level_user) {
                case 'kasir':
                    return redirect()->route('kasir.index');
                case 'admin':
                    return redirect()->route('admin-dashboard.index');
                case 'gudang':
                    return redirect()->route('gudang-dashboard.index');
                case 'owner':
                    return redirect()->route('owner-dashboard.index');
                default:
                    abort(403, 'Unauthorized action.');
            }
        }

        return redirect()->intended(route('login', absolute: false));
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
