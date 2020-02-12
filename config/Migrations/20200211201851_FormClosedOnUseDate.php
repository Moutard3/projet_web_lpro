<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class FormClosedOnUseDate extends AbstractMigration
{
    public function up()
    {

        $this->table('forms')
            ->changeColumn('closed_on', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('forms')
            ->changeColumn('closed_on', 'datetime', [
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();
    }
}
