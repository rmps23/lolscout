<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\DemoSeeder;
use Database\Seeders\LookupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    private function queriesDuring(callable $callback): int
    {
        $count = 0;
        DB::listen(function () use (&$count) {
            $count++;
        });
        $callback();

        return $count;
    }

    public function test_lookup_seeder_is_a_cheap_no_op_once_the_data_exists(): void
    {
        $first = $this->queriesDuring(fn () => $this->seed(LookupSeeder::class));
        $second = $this->queriesDuring(fn () => $this->seed(LookupSeeder::class));

        $this->assertGreaterThan(100, $first);
        $this->assertLessThanOrEqual(3, $second);
        $this->assertSame(8, Role::count());
    }

    public function test_lookup_seeder_fills_in_missing_rows(): void
    {
        $this->seed(LookupSeeder::class);
        Role::where('slug', 'coach')->delete();

        $this->seed(LookupSeeder::class);

        $this->assertSame(8, Role::count());
    }

    public function test_demo_seeder_refuses_production_without_showcase(): void
    {
        $this->app['env'] = 'production';
        config(['app.showcase' => false, 'app.demo_password' => 'Pw-for-tests-123']);

        app(DemoSeeder::class)->__invoke();

        $this->assertSame(0, User::count());
    }

    public function test_demo_seeder_skips_the_slow_work_on_restarts_in_showcase(): void
    {
        $this->app['env'] = 'production';
        config(['app.showcase' => true, 'app.demo_password' => 'Pw-for-tests-123']);

        app(DemoSeeder::class)->__invoke();
        $users = User::count();
        $restart = $this->queriesDuring(fn () => app(DemoSeeder::class)->__invoke());

        $this->assertSame(6, $users);
        $this->assertLessThanOrEqual(3, $restart);
        $this->assertSame(6, User::count());
    }

    public function test_demo_seeder_reapplies_when_the_demo_password_changes(): void
    {
        $this->app['env'] = 'production';
        config(['app.showcase' => true, 'app.demo_password' => 'Pw-for-tests-123']);
        app(DemoSeeder::class)->__invoke();

        config(['app.demo_password' => 'A-new-password-456']);
        app(DemoSeeder::class)->__invoke();

        $demo = User::where('email', 'demo@lolscout.test')->first();
        $this->assertTrue(password_verify('A-new-password-456', $demo->password));
    }
}
