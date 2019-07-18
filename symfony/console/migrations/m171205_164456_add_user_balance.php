<?php

use yii\db\Migration;

/**
 * Class m171205_164456_add_user_balance
 */
class m171205_164456_add_user_balance extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable( 'user_balance', [
            'id'              => $this->bigPrimaryKey(),
            'user_id'         => $this->bigInteger()->notNull(),
            'currency_id'     => $this->bigInteger()->notNull(),
            'money_amount'    => $this->money()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'user_balance_fk0',
            'user_balance',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'user_balance_fk1',
            'user_balance',
            'currency_id',
            'currency',
            'id',
            'CASCADE'
        );

        $this->insert('user_balance', [
            'user_id'         => 1,
            'currency_id'     => 2,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'user_balance_fk0',
            'user_balance'
        );

        $this->dropForeignKey(
            'user_balance_fk1',
            'user_balance'
        );

        $this->dropTable('user_balance');
    }
}
