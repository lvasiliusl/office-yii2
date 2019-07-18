<?php

use yii\db\Migration;

/**
 * Handles adding projects_count to table `client`.
 *
 * php yii migrate/to m170921_151331_add_projects_count_column_to_client_table
 */
class m170921_151331_add_projects_count_column_to_client_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('client', 'projects_count', $this->integer(11));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('client', 'projects_count');
    }
}
