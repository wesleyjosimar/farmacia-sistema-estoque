<?php

use yii\db\Migration;

/**
 * Adiciona chaves estrangeiras para garantir integridade referencial em stock_movement.
 */
class m250701_000001_add_foreign_keys_to_stock_movement extends Migration
{
    public function safeUp()
    {
        // Adiciona foreign key para product_id
        $this->addForeignKey(
            'fk_stock_movement_product',
            'stock_movement',
            'product_id',
            'product',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        // Adiciona foreign key para user_id
        $this->addForeignKey(
            'fk_stock_movement_user',
            'stock_movement',
            'user_id',
            'user',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_stock_movement_product', 'stock_movement');
        $this->dropForeignKey('fk_stock_movement_user', 'stock_movement');
    }
} 