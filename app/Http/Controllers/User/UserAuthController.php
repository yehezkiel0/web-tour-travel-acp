<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserAuthController extends Controller
{
    public function login_register()
    {
        return view('front.login-register');
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $check = $request->all();
        $credentials = [
            'email' => $check['email'],
            'password' => $check['password'],
            'status' => 1,
        ];

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Login is successful!');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password')->withInput();
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login_register')->with('success', 'Logout is successful!');
    }

    public function register_submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required||min:8|confirmed',
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $token = hash('sha256', time());
        $data['token'] = $token;
        $user = User::create($data);

        if (!$user) {
            return redirect()->back()->with('error', 'Registration failed');
        }

        session(['register_token' => $token]);
        session(['register_email' => $request->email]);

        $verification_link = route('register_verify');
        $subject = "User Account Verification";
        $message = "To complete registration, please click on the link below:<br>";
        $message .= "<a href='" . $verification_link . "'>Click Here</a>";

        Mail::to($request->email)->send(new Websitemail($subject, $message));

        return redirect()->back()
            ->with('success', 'Your registration is completed. Please check your email for verification. If you do not find the email in your inbox, please check your spam folder.')
            ->with('slide', 'register');
    }

    public function register_verify()
    {
        $token = session('register_token');
        $email = session('register_email');

        if (!$token || !$email) {
            return redirect()->route('login_register')->with('error', 'Token or email is not correct');
        }

        $user = User::where('email', $email)->where('token', $token)->first();
        if (!$user) {
            return redirect()->route('login-register')->with('error', 'Token or email is not correct');
        }

        $user->token = "";
        $user->status = 1;
        $user->update();

        session()->forget('register_token');
        session()->forget('register_email');

        return redirect()->route('login_register')->with('success', 'Your account is verified. You can login now.');
    }

    public function forget_password()
    {
        return view('front.forget-password');
    }

    public function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email is not found');
        }

        $token = hash('sha256', time());

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        session(['reset_token' => $token]);
        session(['reset_email' => $request->email]);

        $reset_link = route('reset_password');
        $subject = "Password Reset";
        $message = "To reset password, please click on the link below:<br>";
        $message .= "<a href='" . $reset_link . "'>Click here</a>";

        Mail::to($request->email)->send(new Websitemail($subject, $message));

        return redirect()->back()->with('success', 'Password reset link sent to your email. Please check your email.');
    }

    public function reset_password(Request $request)
    {
        $token = session('reset_token');
        $email = session('reset_email');

        if (!$token || !$email) {
            return redirect()->route('login_register')->with('error', 'Token or email is not correct');
        }

        return view('front.reset-password', compact('token', 'email'));
    }

    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $token = session('reset_token');
        $email = session('reset_email');

        if (!$token || !$email) {
            return redirect()->route('login_register')->with('error', 'Invalid or expired link');
        }
        $token_data = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$token_data) {
            return redirect()->route('login_register')->with('error', 'Token or email is not correct');
        }

        $createdAt = \Carbon\Carbon::parse($token_data->created_at);
        $expiryDate = $createdAt->addMinutes(10);

        if (now() > $expiryDate) {
            return redirect()->route('login_register')->with('error', 'Token has expired. Please request a new password reset link.');
        }

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->update();

            DB::table('password_reset_tokens')->where('email', $email)->delete();

            session()->forget('reset_token');
            session()->forget('reset_email');

            DB::table('sessions')->where('user_id', $user->id)->delete();

            return redirect()->route('login_register')->with('success', 'Password has been reset successfully. Please login with your new password.');
        }
    }
}