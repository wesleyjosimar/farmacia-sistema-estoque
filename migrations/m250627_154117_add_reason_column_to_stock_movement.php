<?php

use yii\db\Migration;

class m250627_154117_add_reason_column_to_stock_movement extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250627_154117_add_reason_column_to_stock_movement cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250627_154117_add_reason_column_to_stock_movement cannot be reverted.\n";

        return false;
    }
    */
}
