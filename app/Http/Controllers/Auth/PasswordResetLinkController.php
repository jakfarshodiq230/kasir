<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    // public function create(): View
    // {
    //     return view('auth.forgot-password');
    // }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'email' => ['required', 'email'],
    //     ]);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     return $status == Password::RESET_LINK_SENT
    //         ? back()->with('status', __($status))
    //         : back()->withInput($request->only('email'))
    //         ->withErrors(['email' => __($status)]);
    // }

    public function store(Request $request)
    {
        // Validate the email field
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Attempt to send the password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Check the status and return JSON response
        if ($status == Password::RESET_LINK_SENT) {
            Auth::logout();
            return response()->json([
                'status' => 'success',
                'message' => 'A reset link has been sent to your email address.'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'errors' => [
                'email' => 'The provided email does not exist in our records.'
            ]
        ], 400);
    }
}
