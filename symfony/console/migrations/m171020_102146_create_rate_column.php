<?php

use yii\db\Migration;
/**
 * add 'manager' role.
 *
 * php yii migrate/to m171020_102146_create_rate_column
 *
 */

class m171020_102146_create_rate_column extends Migration
{
    public function up()
    {
        $this->execute("CREATE TYPE rate_column AS ENUM ( 'fixed', 'hourly')");
        $this->addColumn('user', 'salary_type', 'rate_column');
    }

    public function down()
    {
        $this->dropColumn('user', 'salary_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171020_102146_create_rate_column cannot be reverted.\n";

        return false;
    }
    */
}
