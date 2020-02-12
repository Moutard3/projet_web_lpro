<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Question seed.
 */
class QuestionSeed extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'ThemeSeed',
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

        $themes = $this->getAdapter()->fetchAll("select id from themes");

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'theme_id' => $faker->randomElement($themes)['id'],
                'display_text' => $faker->sentence(4).' ?',
           ];
        }

        $table = $this->table('questions');
        $table->insert($data)->save();
    }
}
