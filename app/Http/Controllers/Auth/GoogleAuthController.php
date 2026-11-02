<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists in database by google_id or email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // If user exists but google_id wasn't linked yet, update it
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                }

                // Authenticate user session
                Auth::login($user, true);

                // Redirect based on user role
                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard')->with('success', 'Successfully logged in with Google!');
                }

                return redirect()->route('staff.dashboard')->with('success', 'Successfully logged in with Google!');
            }

            // If user does NOT exist, store Google data in session and prompt for role selection
            session([
                'google_user' => [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]
            ]);

            return redirect()->route('auth.google.role');

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed or was cancelled. Please try again.');
        }
    }

    /**
     * Show the role selection view for new Google users.
     */
    public function showRoleSelection()
    {
        // Ensure session has the temporary google user data
        if (!session()->has('google_user')) {
            return redirect()->route('login')->with('error', 'Session expired. Please try signing in with Google again.');
        }

        return view('auth.google-role');
    }

    /**
     * Store the selected role and register the user.
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'role' => ['required', 'string', 'in:admin,staff'],
        ]);

        $googleData = session('google_user');

        if (!$googleData) {
            return redirect()->route('login')->with('error', 'Session expired. Please try again.');
        }

        // Create the new user with the chosen role (lowercase)
        $user = User::create([
            'name' => $googleData['name'],
            'email' => $googleData['email'],
            'google_id' => $googleData['google_id'],
            'role' => $request->role,
            'password' => Hash::make(Str::random(16)), // Dummy random password
        ]);

        // Clear the temporary session data
        session()->forget('google_user');

        // Log the user in
        Auth::login($user, true);

        // Redirect based on user role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Account created successfully with Google!');
        }

        return redirect()->route('staff.dashboard')->with('success', 'Account created successfully with Google!');
    }
}