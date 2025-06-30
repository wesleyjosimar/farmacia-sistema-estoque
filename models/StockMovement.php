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
            [['type', 'reason'], 'string', 'max' => 20, 'tooLong' => 'Máximo de 20 caracteres.'],
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
