<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // users
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            ['name' => 'Admin', 'password' => Hash::make('123456789'), 'role' => 'admin']
        );

        $employee = User::firstOrCreate(
            ['email' => 'employee@test.com'],
            ['name' => 'Employee', 'password' => Hash::make('123456789'), 'role' => 'employee']
        );

        $user = User::firstOrCreate(
            ['email' => 'user@test.com'],
            ['name' => 'User', 'password' => Hash::make('123456789'), 'role' => 'user']
        );

        // categories (fixed names to avoid unique conflicts)
        $names = ['Action','Drama','Comedy','Sci-Fi','Documentary','Horror','Animation','Thriller'];
        $categories = collect($names)->map(fn($n) => Category::firstOrCreate(['name' => $n]));

        // series + episodes
        Series::factory()->count(10)->create()->each(function (Series $s) use ($categories) {
            // attach 1–3 random categories
            $s->categories()->sync($categories->random(rand(1,3))->pluck('id')->all());

            // episodes 6–12
            Episode::factory()->count(rand(6,12))->create([
                'series_id' => $s->id,
            ]);
        });

        // favorites for demo user (attach 2–4 series)
        $someSeries = Series::inRandomOrder()->take(rand(2,4))->pluck('id');
        $user->favorites()->syncWithoutDetaching($someSeries->all());
    }
}
