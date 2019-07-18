<?php

use yii\db\Migration;

/**
 * Class m171225_111121_create_holiday_calendar
 */
class m171225_111121_create_holiday_calendar extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE month_column AS ENUM ('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')");
        $this->createTable( 'holidays', [
          'id'          => $this->primaryKey(),
          'description' => $this->string()->notNull(),
          'day'         => $this->integer()->notNull(),
          'month'       => 'month_column'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('holidays');
        $this->execute("DROP TYPE month_column");
    }

}
