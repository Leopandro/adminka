<?php
namespace Database\Seeders;

use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Domain\User\Model\User;

/**
 * Class UserSeeder
 * Создаёт пользователей с определенными ролями
 */
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \BenSampo\Enum\Exceptions\InvalidEnumMemberException
     */
    public function run()
    {
        /** @var Generator $faker */
        $faker = app(\Faker\Generator::class);

        /** @var User $user */
        $user = app(User::class)->create([
            'email' => 'admin_0@example.net',
            'password' => Hash::make('!@#QWEasd'),
            'login' => 'admin',
            'name' => $faker->firstName,
            'surname' => $faker->text(10),
            'middle_name' => $faker->lastName,
            'email_verified_at' => now(),
        ]);
        $user->save();
    }
}
