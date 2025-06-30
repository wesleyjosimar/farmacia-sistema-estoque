<?php

use yii\db\Migration;

class m250627_151200_add_details_to_product_table extends Migration
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
        echo "m250627_151200_add_details_to_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250627_151200_add_details_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
