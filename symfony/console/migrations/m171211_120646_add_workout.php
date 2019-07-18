<?php

use yii\db\Migration;

/**
 * Class m171211_120646_add_workout
 */
class m171211_120646_add_workout extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('workout', [
            'id'               => $this->bigPrimaryKey(),
            'project_id'       => $this->bigInteger(),
            'user_id'          => $this->bigInteger()->notNull(),
            'rate_type'        => 'rate_column',
            'rate'             => $this->integer(),
            'hours'            => $this->time(),
            'fixed'            => $this->money(),
            'currency_id'      => $this->bigInteger()->notNull(),
            'workout_date'     => $this->integer()->notNull(),
            'created_at'       => $this->integer()->notNull(),
            'description'      => $this->string(),
        ]);

        $this->createTable('workout_transactions', [
            'id'               => $this->bigPrimaryKey(),
            'workout_id'       => $this->bigInteger()->notNull(),
            'user_balance_id'  => $this->bigInteger()->notNull(),
            'summ'             => $this->money()->notNull(),
            'created_at'       => $this->integer()->notNull(),
        ]);

        $this->execute(
            "CREATE OR REPLACE FUNCTION user_balance_calculation() RETURNS TRIGGER AS $$
            DECLARE
            id_user_balance int;
            user_balance_summ numeric(19,2);
            workout_minutes numeric(19,4);
            workout_hours numeric(19,4);
            BEGIN
            id_user_balance = (SELECT id FROM user_balance WHERE user_id = NEW.user_id );
            IF (NEW.rate_type = 'hourly') THEN

            IF (EXTRACT(MINUTE FROM  NEW.hours)!= 0) THEN
            SELECT ((EXTRACT(MINUTE FROM  NEW.hours) * 100 / 60) / 100) INTO workout_minutes;
            SELECT (EXTRACT(HOUR FROM  NEW.hours)) INTO workout_hours;
            user_balance_summ = (workout_hours + workout_minutes) * NEW.rate;
            ELSE
            SELECT (EXTRACT(HOUR FROM  NEW.hours)) INTO workout_hours;
            user_balance_summ = workout_hours * NEW.rate;
            END IF;
            INSERT INTO workout_transactions (workout_id, user_balance_id, summ, created_at) VALUES (NEW.id, id_user_balance, user_balance_summ, NEW.created_at);
            UPDATE user_balance SET money_amount = money_amount + user_balance_summ WHERE user_id = NEW.user_id;
            END IF;
            IF (NEW.rate_type = 'fixed') THEN
            INSERT INTO workout_transactions (workout_id, user_balance_id, summ, created_at) VALUES (NEW.id, id_user_balance, NEW.fixed, NEW.created_at);
            UPDATE user_balance SET money_amount = money_amount + NEW.fixed WHERE user_id = NEW.user_id;
            END IF;
            RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;"
        );

        $this->execute(
            "CREATE OR REPLACE LANGUAGE plpgsql;"
        );

        $this->execute(
            "CREATE TRIGGER workout_trigger AFTER INSERT ON workout FOR EACH ROW EXECUTE PROCEDURE user_balance_calculation();"
        );

        $this->addForeignKey(
            'workout_fk0',
            'workout',
            'project_id',
            'project',
            'id'
        );

        $this->addForeignKey(
            'workout_fk1',
            'workout',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'workout_fk2',
            'workout',
            'currency_id',
            'currency',
            'id'
        );

        $this->addForeignKey(
            'workout_transactions_fk0',
            'workout_transactions',
            'workout_id',
            'workout',
            'id'
        );

        $this->addForeignKey(
            'workout_transactions_fk1',
            'workout_transactions',
            'user_balance_id',
            'user_balance',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'workout_fk0',
            'workout'
        );
        $this->dropForeignKey(
            'workout_fk1',
            'workout'
        );
        $this->dropForeignKey(
            'workout_fk2',
            'workout'
        );
        $this->dropForeignKey(
            'workout_transactions_fk0',
            'workout_transactions'
        );
        $this->dropForeignKey(
            'workout_transactions_fk1',
            'workout_transactions'
        );

        $this->dropTable('workout');
        $this->dropTable('workout_transactions');
    }
}
