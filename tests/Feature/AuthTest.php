<?php

namespace Tests\Feature;

use App\Models\Nation;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\LookupSeeder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LookupSeeder::class);
    }

    private function registrationData(array $override = []): array
    {
        return $override + [
            'username' => 'Faker',
            'email' => 'faker@example.com',
            'password' => 'Secret12345',
            'password_confirmation' => 'Secret12345',
            'nation_id' => Nation::first()->id,
            'role_id' => Role::first()->id,
        ];
    }

    public function test_user_can_register_and_receives_verification_email(): void
    {
        Notification::fake();

        $this->post('/register', $this->registrationData())->assertRedirect(route('verification.notice'));

        $user = User::where('email', 'faker@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('Secret12345', $user->password));
        $this->assertNull($user->email_verified_at);
        $this->assertAuthenticatedAs($user);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_registration_rejects_weak_password_and_duplicates(): void
    {
        $this->post('/register', $this->registrationData(['password' => 'short', 'password_confirmation' => 'short']))
            ->assertSessionHasErrors('password');

        User::factory()->create(['email' => 'faker@example.com', 'username' => 'Faker']);
        $this->post('/register', $this->registrationData())->assertSessionHasErrors(['username', 'email']);
        $this->assertGuest();
    }

    public function test_registration_rejects_reserved_and_invalid_usernames(): void
    {
        $this->post('/register', $this->registrationData(['username' => 'admin']))->assertSessionHasErrors('username');
        $this->post('/register', $this->registrationData(['username' => '<script>']))->assertSessionHasErrors('username');
    }

    public function test_login_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'Secret12345']);

        $this->post('/login', ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post('/login', ['email' => $user->email, 'password' => 'Secret12345'])
            ->assertRedirect(route('settings.account'));
        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_unverified_user_cannot_open_settings_until_verified(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)->get('/settings/account')->assertRedirect(route('verification.notice'));

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
            'id' => $user->id,
            'hash' => sha1($user->email),
        ]);
        $this->actingAs($user)->get($url)->assertRedirect(route('settings.account'));
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_guest_is_sent_to_login(): void
    {
        $this->get('/settings/account')->assertRedirect(route('login'));
    }

    public function test_password_reset_flow_does_not_reveal_unknown_emails(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $known = $this->post('/forgot-password', ['email' => $user->email]);
        $unknown = $this->post('/forgot-password', ['email' => 'nobody@example.com']);
        $this->assertSame($known->getSession()->get('status'), $unknown->getSession()->get('status'));
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'BrandNew12345',
                'password_confirmation' => 'BrandNew12345',
            ])->assertRedirect(route('login'));

            return true;
        });
        $this->assertTrue(Hash::check('BrandNew12345', $user->fresh()->password));
    }

    public function test_user_can_update_profile_but_not_steal_a_username(): void
    {
        User::factory()->create(['username' => 'Taken']);
        $user = User::factory()->create();

        $this->actingAs($user)->put('/settings/profile', [
            'username' => 'Taken', 'role_id' => Role::first()->id, 'nation_id' => Nation::first()->id,
        ])->assertSessionHasErrors('username');

        $this->actingAs($user)->put('/settings/profile', [
            'username' => 'NewName', 'role_id' => Role::first()->id, 'nation_id' => Nation::first()->id, 'bio' => 'Hi',
        ])->assertSessionHasNoErrors();
        $this->assertSame('NewName', $user->fresh()->username);
    }

    public function test_changing_password_requires_current_password(): void
    {
        $user = User::factory()->create(['password' => 'Secret12345']);

        $this->actingAs($user)->put('/settings/password', [
            'current_password' => 'nope', 'password' => 'BrandNew12345', 'password_confirmation' => 'BrandNew12345',
        ])->assertSessionHasErrors('current_password');

        $this->actingAs($user)->put('/settings/password', [
            'current_password' => 'Secret12345', 'password' => 'BrandNew12345', 'password_confirmation' => 'BrandNew12345',
        ])->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('BrandNew12345', $user->fresh()->password));
    }

    public function test_changing_email_requires_reverification(): void
    {
        Notification::fake();
        $user = User::factory()->create(['password' => 'Secret12345']);

        $this->actingAs($user)->put('/settings/email', ['email' => 'new@example.com', 'current_password' => 'Secret12345'])
            ->assertRedirect(route('verification.notice'));

        $user->refresh();
        $this->assertSame('new@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_user_can_delete_account_with_password(): void
    {
        $user = User::factory()->create(['password' => 'Secret12345']);

        $this->actingAs($user)->delete('/settings/account', ['delete_password' => 'wrong'])
            ->assertSessionHasErrors('delete_password');
        $this->assertModelExists($user);

        $this->actingAs($user)->delete('/settings/account', ['delete_password' => 'Secret12345'])
            ->assertRedirect(route('home'));
        $this->assertModelMissing($user);
        $this->assertGuest();
    }

    public function test_responses_carry_security_headers(): void
    {
        $this->get('/login')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
