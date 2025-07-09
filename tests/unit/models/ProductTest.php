<?php

namespace tests\unit\models;

use app\models\Product;

class ProductTest extends \Codeception\Test\Unit
{
    public function testQuantidadeNegativa()
    {
        $model = new Product([
            'name' => 'Teste',
            'quantity' => -1,
            'price' => 10.0,
            'expiry_date' => date('Y-m-d', strtotime('+1 year')),
            'minimum_stock' => 0,
            'category' => 'Teste',
            'manufacturer' => 'Teste',
            'batch' => 'Lote',
            'barcode' => '123',
        ]);
        $this->assertFalse($model->validate(['quantity']));
    }

    public function testEstoqueMinimoNegativo()
    {
        $model = new Product([
            'name' => 'Teste',
            'quantity' => 10,
            'price' => 10.0,
            'expiry_date' => date('Y-m-d', strtotime('+1 year')),
            'minimum_stock' => -5,
            'category' => 'Teste',
            'manufacturer' => 'Teste',
            'batch' => 'Lote',
            'barcode' => '123',
        ]);
        $this->assertFalse($model->validate(['minimum_stock']));
    }

    public function testValidadeNoPassado()
    {
        $model = new Product([
            'name' => 'Teste',
            'quantity' => 10,
            'price' => 10.0,
            'expiry_date' => date('Y-m-d', strtotime('-1 day')),
            'minimum_stock' => 0,
            'category' => 'Teste',
            'manufacturer' => 'Teste',
            'batch' => 'Lote',
            'barcode' => '123',
        ]);
        $this->assertFalse($model->validate(['expiry_date']));
    }

    public function testProdutoValido()
    {
        $model = new Product([
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
        $this->assertTrue($model->validate());
    }
} 