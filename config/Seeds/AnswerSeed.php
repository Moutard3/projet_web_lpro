<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Answer seed.
 */
class AnswerSeed extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'QuestionSeed',
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

        $questions = $this->getAdapter()->fetchAll("select id from questions");

        $data = [];
        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'question_id' => $faker->randomElement($questions)['id'],
                'valid' => $faker->boolean,
                'display_text' => $faker->sentence(4),
                'feedback' => $faker->sentence(4),
            ];
        }

        $table = $this->table('answers');
        $table->insert($data)->save();
    }
}
