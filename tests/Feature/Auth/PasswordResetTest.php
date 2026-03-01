<?php

use App\Mail\ResetPasswordPinMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

test('reset password link screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
});

test('reset password pin can be requested', function () {
    Mail::fake();

    $user = User::factory()->create();

    $response = $this->post('/forgot-password', ['email' => $user->email]);

    Mail::assertSent(ResetPasswordPinMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });

    $response->assertRedirect(route('password.verify.notice'));
});

test('verify code screen can be rendered when session has email', function () {
    $response = $this->withSession(['reset_email' => 'test@example.com'])->get('/verify-code');

    $response->assertStatus(200);
});

test('correct pin allows access to reset screen', function () {
    $user = User::factory()->create();
    $pin = '123456';

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($pin),
        'created_at' => Carbon::now(),
    ]);

    $response = $this->post('/verify-code', ['email' => $user->email, 'pin' => $pin]);

    $response->assertSessionHas('verified_reset_email', $user->email);
    $response->assertRedirect(route('password.reset.custom'));
});

test('password can be reset with valid token', function () {
    $user = User::factory()->create();
    $pin = '654321';

    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($pin),
        'created_at' => Carbon::now(),
    ]);

    $response = $this->withSession([
        'verified_reset_email' => $user->email,
        'verified_reset_pin' => $pin,
    ])->post('/reset-password-custom', [
        'email' => $user->email,
        'pin' => $pin,
        'password' => 'new-secure-password',
        'password_confirmation' => 'new-secure-password',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('login'));

    $this->assertTrue(Hash::check('new-secure-password', $user->fresh()->password));
});
