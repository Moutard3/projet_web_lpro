<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public $autoId = false;

    public function up()
    {
        $this->table('answers')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('question_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('valid', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('display_text', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('forms')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('created_by', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('display_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('active', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('closed_on', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('forms_questions')
            ->addColumn('form_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('question_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['form_id', 'question_id'])
            ->create();

        $this->table('questions')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('theme_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('display_text', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('student_answers')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('form_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('question_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('answer_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->create();

        $this->table('student_results')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('form_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addPrimaryKey(['user_id', 'form_id'])
            ->addColumn('result', 'float', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('published', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('themes')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('display_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('login', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('password', 'char', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('role', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();
    }

    public function down()
    {
        $this->table('answers')->drop()->save();
        $this->table('forms')->drop()->save();
        $this->table('forms_questions')->drop()->save();
        $this->table('questions')->drop()->save();
        $this->table('student_answers')->drop()->save();
        $this->table('student_results')->drop()->save();
        $this->table('themes')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
