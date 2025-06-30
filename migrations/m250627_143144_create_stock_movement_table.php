<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_movement}}`.
 */
class m250627_143144_create_stock_movement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stock_movement}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->string(10)->notNull(),
            'quantity' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_movement}}');
    }
}
