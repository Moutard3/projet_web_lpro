<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * FormsQuestion seed.
 */
class FormsQuestionSeed extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'FormSeed',
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

        $forms = $this->getAdapter()->fetchAll("select id from forms");
        $questions = $this->getAdapter()->fetchAll("select id from questions");

        $data = [];
        $uniqueCheck = [];
        for ($i = 0; $i < 1000; $i++) {
            $form_id = $faker->randomElement($forms)['id'];
            $question_id = $faker->randomElement($questions)['id'];
            if (in_array($form_id.'-'.$question_id, $uniqueCheck)) continue;
            $uniqueCheck[] = $form_id.'-'.$question_id;

            $data[] = [
                'form_id' => $form_id,
                'question_id' => $question_id,
            ];
        }

        $table = $this->table('forms_questions');
        $table->insert($data)->save();
    }
}
