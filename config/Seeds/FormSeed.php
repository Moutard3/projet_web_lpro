<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Forms seed.
 */
class FormSeed extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'UserSeed',
        ];
    }

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
        $faker = Faker\Factory::create();

        $admins = $this->getAdapter()->fetchAll("select id from users where role = 'admin'");

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'created_by' => $faker->randomElement($admins)['id'],
                'display_name' => $faker->sentence(4),
                'active' => $faker->boolean,
                'closed_on' => $faker->randomElement([$faker->dateTimeBetween('-2 month', '+2 month', 'Europe/Paris')->format('Y-m-d'), null]),
            ];
        }

        $table = $this->table('forms');
        $table->insert($data)->save();
    }
}
