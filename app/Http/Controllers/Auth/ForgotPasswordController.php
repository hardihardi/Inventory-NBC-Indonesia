<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form Lupa Password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Kirim link reset password ke email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Kirim Email (Untuk testing biasanya gunakan log atau Mailtrap)
        // Link: url('/password/reset/'.$token.'?email='.$request->email)
        $resetLink = url('/password/reset/' . $token . '?email=' . urlencode($request->email));

        try {
            Mail::send('emails.password-reset', ['link' => $resetLink], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password - ' . config('app.name'));
            });
        } catch (\Exception $e) {
            // Jika mail server tidak tersetting, log link reset untuk keperluan debug/manual
            \Illuminate\Support\Facades\Log::info("Password reset link for {$request->email}: {$resetLink}");
            
            // Berikan feedback ke user (walaupun gagal kirim email, jangan beri tahu detail error jika bukan debug)
            if (config('app.debug')) {
                 return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage() . '. Link reset (DEBUG): ' . $resetLink);
            }
        }

        return back()->with('status', 'Kami telah mengirimkan instruksi reset password ke email Anda.');
    }

    /**
     * Tampilkan form reset password.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Proses reset password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.']);
        }

        // Cek kadaluarsa (misal 60 menit)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
             return back()->withErrors(['email' => 'Token reset password sudah kadaluarsa.']);
        }

        // Update password user
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password Anda berhasil diperbarui. Silakan login dengan password baru.');
    }
}
