<?php

use yii\db\Migration;

/**
 * Class m171206_135238_edit_user_table
 */
class m171206_135238_edit_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'currency_id', $this->bigInteger()->notNull()->defaultValue(2));
        $this->addForeignKey(
            'user_fk0',
            'user',
            'currency_id',
            'currency',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171206_135238_edit_user_table cannot be reverted.\n";

        return false;
    }
}
