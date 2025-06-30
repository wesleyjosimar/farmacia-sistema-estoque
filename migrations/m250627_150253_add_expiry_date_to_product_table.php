<?php

use yii\db\Migration;

class m250627_150253_add_expiry_date_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'expiry_date', $this->date()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product', 'expiry_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250627_150253_add_expiry_date_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
