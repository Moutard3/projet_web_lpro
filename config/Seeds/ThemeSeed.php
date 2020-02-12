<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Themes seed.
 */
class ThemeSeed extends AbstractSeed
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
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'display_name' => $faker->sentence(2),
            ];
        }

        $table = $this->table('themes');
        $table->insert($data)->save();
    }
}
