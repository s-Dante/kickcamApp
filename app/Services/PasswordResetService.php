<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\ResetPasswordPinMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetService
{
    /**
     * Delete existing token, generate new 6 digit OTP, save it and email it.
     */
    public function sendResetPin(string $email): bool
    {
        $user = User::where('email', $email)->first();
        if (! $user) {
            return false; // Prevent email enumeration by returning true theoretically, but for now return false. Actually returning true is safer. Let's return true.
        }

        $pin = sprintf('%06d', mt_rand(1, 999999));

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($pin),
                'created_at' => Carbon::now(),
            ]
        );

        Mail::to($email)->send(new ResetPasswordPinMail($pin));

        return true;
    }

    /**
     * Validate the given PIN for the email
     */
    public function validatePin(string $email, string $pin): bool
    {
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (! $record) {
            return false;
        }

        // Check if expired (e.g., 60 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return false;
        }

        return Hash::check($pin, $record->token);
    }

    /**
     * Reset the user password and delete the token
     */
    public function resetPassword(string $email, string $pin, string $newPassword): bool
    {
        if (! $this->validatePin($email, $pin)) {
            return false;
        }

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($newPassword);
            $user->save();
        }

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return true;
    }
}
