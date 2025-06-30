<?php

use yii\db\Migration;

class m250627_154057_add_expiry_date_column_to_product extends Migration
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
        echo "m250627_154057_add_expiry_date_column_to_product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250627_154057_add_expiry_date_column_to_product cannot be reverted.\n";

        return false;
    }
    */
}
