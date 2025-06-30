<?php

use yii\db\Migration;

class m250627_151707_add_reason_to_stock_movement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('stock_movement', 'reason', $this->string(50)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('stock_movement', 'reason');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250627_151707_add_reason_to_stock_movement_table cannot be reverted.\n";

        return false;
    }
    */
}
