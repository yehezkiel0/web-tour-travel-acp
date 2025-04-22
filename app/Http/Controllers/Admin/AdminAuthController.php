<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();

            // Cek role user
            if ($user->role === 'admin') { // Sesuaikan dengan nilai role di database
                return redirect()->route('admin_dashboard')->with('success', 'Login admin berhasil!');
            } else {
                Auth::logout(); // Logout jika bukan admin
                return redirect()->back()->with('error', 'Akses hanya untuk admin.');
            }
        } else {
            return redirect()->back()->with('error', 'Email atau password salah.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin_login')->with('success', 'Logout is successful!');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profile_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $admin = User::where('id', Auth::id())->where('role', 'admin')->first();

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'mimes:jpg,jpeg,png|max:2048',
            ]);

            $uploadPath = 'uploads';
            if (!Storage::disk('public')->exists($uploadPath)) {
                Storage::disk('public')->makeDirectory($uploadPath);
            }

            $photoName = 'upload_profile_' . time() . '.' . $request->photo->extension();
            $path = $request->file('photo')->storeAs($uploadPath, $photoName, 'public');

            if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
                Storage::disk('public')->delete($uploadPath . $admin->photo);
            }

            $admin->photo = $path;
            $admin->save();
        }


        if ($request->password) {
            $request->validate([
                'password' => 'required|confirmed',
            ]);
            $admin->password = Hash::make($request->password);
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->update();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function forget_password()
    {
        return view('admin.auth.forget-password');
    }

    public function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin = User::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->back()->with('error', 'Email is not found');
        }

        $token = hash('sha256', time());

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        session(['reset_token' => $token]);
        session(['reset_email' => $request->email]);

        $reset_link = url('/admin/reset-password');
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
            return redirect()->route('admin_login')->with('error', 'Token or email is not correct');
        }

        return view('admin.auth.reset-password', compact('token', 'email'));
    }

    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $token = session('reset_token');
        $email = session('reset_email');

        if (!$token || !$email) {
            return redirect()->route('admin_login')->with('error', 'Invalid or expired link');
        }
        $token_data = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$token_data) {
            return redirect()->route('admin_login')->with('error', 'Token or email is not correct');
        }

        $createdAt = \Carbon\Carbon::parse($token_data->created_at);
        $expiryDate = $createdAt->addMinutes(10);

        if (now() > $expiryDate) {
            return redirect()->route('admin_login')->with('error', 'Token has expired. Please request a new password reset link.');
        }

        $admin = User::where('email', $email)->first();
        if ($admin) {
            $admin->password = Hash::make($request->password);
            $admin->update();

            DB::table('password_reset_tokens')->where('email', $email)->delete();

            session()->forget('reset_token');
            session()->forget('reset_email');

            DB::table('sessions')->where('user_id', $admin->id)->delete();

            return redirect()->route('admin_login')->with('success', 'Password has been reset successfully. Please login with your new password.');
        }
    }
}
