<?php

namespace app\models;

use Yii;

/**
 * Modelo que representa a tabela "product" no banco de dados.
 * Aqui ficam as regras de validação, nomes dos campos e relacionamentos.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $quantity
 * @property float $price
 * @property string|null $expiry_date
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $minimum_stock
 * @property string|null $category
 * @property string|null $manufacturer
 * @property string|null $batch
 * @property string|null $barcode
 */
class Product extends \yii\db\ActiveRecord
{
    // Informa ao Yii que este model está ligado à tabela 'product'
    public static function tableName()
    {
        return 'product';
    }

    // Regras de validação dos campos do formulário
    public function rules()
    {
        return [
            // Campos obrigatórios
            [['name', 'quantity', 'price', 'expiry_date', 'minimum_stock', 'category', 'manufacturer', 'batch', 'barcode'], 'required', 'message' => 'Este campo é obrigatório.'],
            // Campos que devem ser inteiros
            [['quantity', 'minimum_stock', 'created_at', 'updated_at'], 'integer', 'message' => 'Informe um valor inteiro.'],
            // quantity e minimum_stock não podem ser negativos
            [['quantity', 'minimum_stock'], 'integer', 'min' => 0, 'tooSmall' => 'O valor não pode ser negativo.'],
            // Campo que deve ser numérico (aceita decimais)
            [['price'], 'number', 'message' => 'Informe um valor numérico.'],
            // Campo de data no formato ano-mês-dia
            [['expiry_date'], 'date', 'format' => 'php:Y-m-d', 'message' => 'Informe uma data válida.'],
            // Validade não pode ser no passado (exceto se já estiver vencido)
            ['expiry_date', function($attribute, $params, $validator) {
                if (strtotime($this->$attribute) < strtotime(date('Y-m-d'))) {
                    $this->addError($attribute, 'A validade não pode ser no passado.');
                }
            }, 'when' => function($model) {
                // Só valida se não for edição de produto já vencido
                return empty($model->id) || (strtotime($model->expiry_date) >= strtotime(date('Y-m-d')));
            }],
            // Campos de texto com limite de caracteres
            [['name', 'category', 'manufacturer', 'batch', 'barcode'], 'string', 'max' => 255, 'tooLong' => 'Máximo de 255 caracteres.'],
            [['description'], 'string', 'max' => 1000, 'tooLong' => 'Máximo de 1000 caracteres.'],
        ];
    }

    // Nomes amigáveis para os campos (usados nos formulários e telas)
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'description' => 'Descrição',
            'quantity' => 'Quantidade',
            'price' => 'Preço',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
            'expiry_date' => 'Validade',
            'minimum_stock' => 'Estoque Mínimo',
            'category' => 'Categoria',
            'manufacturer' => 'Fabricante',
            'batch' => 'Lote',
            'barcode' => 'Código de Barras',
        ];
    }

    /**
     * Relacionamento: retorna as movimentações de estoque relacionadas a este produto
     */
    public function getMovements()
    {
        // Um produto pode ter várias movimentações de estoque
        return $this->hasMany(\app\models\StockMovement::class, ['product_id' => 'id']);
    }
}
