<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stock_movement".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string $type
 * @property int $quantity
 * @property int|null $created_at
 * @property string|null $reason
 */
class StockMovement extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_movement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id', 'type', 'quantity', 'created_at', 'reason'], 'required', 'message' => 'Este campo é obrigatório.'],
            [['product_id', 'user_id', 'quantity', 'created_at'], 'integer', 'message' => 'Informe um valor inteiro.'],
            // quantity deve ser maior que zero
            ['quantity', 'integer', 'min' => 1, 'tooSmall' => 'A quantidade deve ser maior que zero.'],
            [['type', 'reason'], 'string', 'max' => 20, 'tooLong' => 'Máximo de 20 caracteres.'],
            // Validação customizada para saída não ultrapassar estoque (pode zerar)
            ['quantity', function($attribute, $params, $validator) {
                if ($this->type === 'saida' && $this->product) {
                    if ($this->quantity > $this->product->quantity) {
                        $this->addError($attribute, 'A quantidade de saída não pode ser maior que o estoque disponível.');
                    }
                }
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Produto',
            'user_id' => 'Usuário',
            'type' => 'Tipo',
            'quantity' => 'Quantidade',
            'created_at' => 'Data',
            'reason' => 'Motivo',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
