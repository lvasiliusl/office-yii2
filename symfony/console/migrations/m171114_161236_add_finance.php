<?php

use yii\db\Migration;

/**
 * Class m171114_161236_add_finance
 */
class m171114_161236_add_finance extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE commission_type AS ENUM ( 'fixed', 'percentage')");

        $this->createTable( 'currency', [
            'id'              => $this->bigPrimaryKey(),
            'title'           => $this->string(30)->notNull(),
            'code'            => $this->string(5)->notNull(),
            'symbol'          => $this->string(5)->notNull(),
            'symbol_position' => $this->smallInteger()->notNull(),
        ]);

        $this->insert('currency', [
            'title'           => 'Ukraine',
            'code'            => 'UAH',
            'symbol'          => '₴',
            'symbol_position' => '2',
        ]);

        $this->insert('currency', [
            'title'           => 'USA',
            'code'            => 'USD',
            'symbol'          => '$',
            'symbol_position' => '1',
        ]);

        $this->createTable( 'currency_exchange', [
            'id'              => $this->bigPrimaryKey(),
            'created_at'      => $this->integer()->notNull(),
            'currency_id'     => $this->bigInteger()->notNull(),
            'rate'            => $this->money()->notNull(),
        ]);

        $this->createTable( 'office_balance', [
            'id'              => $this->bigPrimaryKey(),
            'name'            => $this->string(30)->notNull(),
            'currency_id'     => $this->bigInteger()->notNull(),
            'money_amount'    => $this->money()->defaultValue(0),
        ]);

        $this->createTable( 'balance_transactions', [
            'id'              => $this->bigPrimaryKey(),
            'balance'         => $this->bigInteger()->notNull(),
            'title'           => $this->string(50)->notNull(),
            'description'     => $this->string(150)->notNull(),
            'summ'            => $this->money()->notNull(),
            'created_at'      => $this->integer()->notNull(),
        ]);

        $this->createTable( 'balance_transactions_temp', [
            'id'              => $this->bigPrimaryKey(),
            'from_balance'    => $this->bigInteger()->notNull(),
            'to_balance'      => $this->bigInteger()->notNull(),
            'from_title'      => $this->string(50)->notNull(),
            'to_title'        => $this->string(50)->notNull(),
            'description'     => $this->string(150)->notNull(),
            'from_summ'       => $this->money()->notNull(),
            'to_summ'         => $this->money()->notNull(),
            'created_at'      => $this->integer()->notNull(),
        ]);

        $this->createTable( 'income_source', [
            'id'              => $this->bigPrimaryKey(),
            'name'            => $this->string(30)->notNull(),
            'currency_id'     => $this->bigInteger()->notNull(),
            'commission'      => $this->money(),
        ]);

        $this->insert( 'income_source', [
            'name'            => 'UpWork',
            'currency_id'     => 2,
        ]);

        $this->addColumn(
            'income_source',
            'commission_type',
            'commission_type'
        );

        $this->createTable( 'income_transactions', [
            'id'              => $this->bigPrimaryKey(),
            'created_at'      => $this->integer()->notNull(),
            'title'           => $this->string(50)->notNull(),
            'description'     => $this->string(150)->notNull(),
            'from'            => $this->bigInteger()->notNull(),
            'to_balance'      => $this->bigInteger()->notNull(),
            'summ'            => $this->money()->notNull(),
            'currency_id'     => $this->bigInteger()->notNull(),
        ]);

        $this->addForeignKey(
            'currency_exchange_fk0',
            'currency_exchange',
            'currency_id',
            'currency',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'income_source_fk0',
            'income_source',
            'currency_id',
            'currency',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'income_transactions_fk0',
            'income_transactions',
            'from',
            'income_source',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'income_transactions_fk1',
            'income_transactions',
            'to_balance',
            'office_balance',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'income_transactions_fk2',
            'income_transactions',
            'currency_id',
            'currency',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'office_balance_fk0',
            'office_balance',
            'currency_id',
            'currency',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'balance_transactions_fk0',
            'balance_transactions',
            'balance',
            'office_balance',
            'id',
            'CASCADE'
        );

        $this->insert('office_balance',[
            'id'              => $this->bigPrimaryKey(),
            'name'            => 'Salary Balance',
            'currency_id'     => 1,
            'money_amount'    => $this->money()->defaultValue(0),
        ]);

        $this->execute(
            "CREATE OR REPLACE FUNCTION balance_calculation() RETURNS TRIGGER AS $$
            DECLARE
            BEGIN
            IF TG_NAME = 'income_transactions' THEN
            UPDATE office_balance SET money_amount = money_amount + NEW.summ WHERE id = NEW.to_balance;
            END IF;
            IF TG_NAME = 'balance_transactions' THEN
            IF (SELECT money_amount FROM office_balance WHERE id = NEW.from_balance) >= NEW.from_summ THEN
            UPDATE office_balance SET money_amount = money_amount - NEW.from_summ WHERE id = NEW.from_balance;
            UPDATE office_balance SET money_amount = money_amount + NEW.to_summ WHERE id = NEW.to_balance;
            INSERT INTO balance_transactions (balance, title, description, summ, created_at) VALUES (NEW.from_balance, NEW.to_title, NEW.description, NEW.from_summ, NEW.created_at);
            INSERT INTO balance_transactions (balance, title, description, summ, created_at) VALUES (NEW.to_balance, NEW.from_title, NEW.description, NEW.to_summ, NEW.created_at);
            END IF;
            DELETE FROM balance_transactions_temp;
            END IF;
            RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;" );

        $this->execute(
            "CREATE OR REPLACE LANGUAGE plpgsql;"
        );

        $this->execute(
            "CREATE TRIGGER income_transactions AFTER INSERT ON income_transactions FOR EACH ROW EXECUTE PROCEDURE balance_calculation();");

        $this->execute(
            "CREATE TRIGGER balance_transactions AFTER INSERT ON balance_transactions_temp FOR EACH ROW EXECUTE PROCEDURE balance_calculation();");

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'currency_exchange_fk0',
            'currency_exchange'
        );

        $this->dropForeignKey(
            'income_source_fk0',
            'income_source'
        );

        $this->dropForeignKey(
            'income_transactions_fk0',
            'income_transactions'
        );

        $this->dropForeignKey(
            'income_transactions_fk1',
            'income_transactions'
        );

        $this->dropForeignKey(
            'income_transactions_fk2',
            'income_transactions'
        );

        $this->dropForeignKey(
            'office_balance_fk0',
            'office_balance'
        );

        $this->dropForeignKey(
            'balance_transactions_fk0',
            'balance_transactions'
        );

        $this->dropTable('income_transactions');
        $this->dropTable('income_source');
        $this->dropTable('balance_transactions');
        $this->dropTable('balance_transactions_temp');
        $this->dropTable('office_balance');
        $this->dropTable('currency_exchange');
        $this->dropTable('currency');

        $this->execute("DROP TYPE commission_type");
    }
}
