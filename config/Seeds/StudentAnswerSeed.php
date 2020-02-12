<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * StudentAnswer seed.
 */
class StudentAnswerSeed extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'UserSeed',
            'FormSeed',
            'QuestionSeed',
            'AnswerSeed',
            'FormsQuestionSeed'
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

        $users = $this->getAdapter()->fetchAll("select id from users where role = 'user'");
        $forms_questions = $this->getAdapter()->fetchAll("select form_id, forms_questions.question_id from forms_questions INNER JOIN answers a on forms_questions.question_id = a.question_id");

        $data = [];
        for ($i = 0; $i < 10000; $i++) {
            $form = $faker->randomElement($forms_questions);
            $question_id = $form['question_id'];
            $form_id = $form['form_id'];
            $answers = $this->getAdapter()->fetchAll("select id from answers where question_id = ".$question_id);

            $data[] = [
                'user_id' => $faker->randomElement($users)['id'],
                'form_id' => $form_id,
                'question_id' => $question_id,
                'answer_id' => $faker->randomElement($answers)['id'],
            ];
        }

        $table = $this->table('student_answers');
        $table->insert($data)->save();
    }
}
