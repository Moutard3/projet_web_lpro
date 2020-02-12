<?php
declare(strict_types=1);

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UserSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $hasher = new DefaultPasswordHasher();
        $faker = Faker\Factory::create();
        $data = [];

        $data[] = [
            'login' => 'admin',
            'password' => $hasher->hash('admin'),
            'role' => 'admin',
            'email' => 'admin@admin.admin',
        ];

        $data[] = [
            'login' => 'user',
            'password' => $hasher->hash('user'),
            'role' => 'user',
            'email' => 'user@user.user',
        ];


        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'login' => $faker->userName,
                'password' => $hasher->hash($faker->password),
                'role' =>  $faker->randomElement(['user', 'admin']),
                'email' => $faker->email,
            ];
        }

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
