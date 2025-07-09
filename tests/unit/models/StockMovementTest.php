<?php

namespace tests\unit\models;

use app\models\StockMovement;
use app\models\Product;

class StockMovementTest extends \Codeception\Test\Unit
{
    public function testQuantidadeZeroOuNegativa()
    {
        $model = new StockMovement([
            'product_id' => 1,
            'user_id' => 1,
            'type' => 'entrada',
            'quantity' => 0,
            'created_at' => time(),
            'reason' => 'Teste',
        ]);
        $this->assertFalse($model->validate(['quantity']));
        $model->quantity = -5;
        $this->assertFalse($model->validate(['quantity']));
    }

    public function testSaidaMaiorQueEstoque()
    {
        $produto = new Product([
            'id' => 1,
            'name' => 'Teste',
            'quantity' => 10,
            'price' => 10.0,
            'expiry_date' => date('Y-m-d', strtotime('+1 year')),
            'minimum_stock' => 0,
            'category' => 'Teste',
            'manufacturer' => 'Teste',
            'batch' => 'Lote',
            'barcode' => '123',
        ]);
        $mov = new StockMovement([
            'product_id' => 1,
            'user_id' => 1,
            'type' => 'saida',
            'quantity' => 20,
            'created_at' => time(),
            'reason' => 'Teste',
        ]);
        // Simula o relacionamento
        $mov->populateRelation('product', $produto);
        $this->assertFalse($mov->validate(['quantity']));
    }

    public function testMovimentacaoValida()
    {
        $produto = new Product([
            'id' => 1,
            'name' => 'Teste',
            'quantity' => 10,
            'price' => 10.0,
            'expiry_date' => date('Y-m-d', strtotime('+1 year')),
            'minimum_stock' => 0,
            'category' => 'Teste',
            'manufacturer' => 'Teste',
            'batch' => 'Lote',
            'barcode' => '123',
        ]);
        $mov = new StockMovement([
            'product_id' => 1,
            'user_id' => 1,
            'type' => 'saida',
            'quantity' => 5,
            'created_at' => time(),
            'reason' => 'Teste',
        ]);
        $mov->populateRelation('product', $produto);
        $this->assertTrue($mov->validate());
    }
} 