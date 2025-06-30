<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

// Modelo que representa a tabela 'user' e implementa autenticação de usuário
class User extends ActiveRecord implements IdentityInterface
{
    public $password; // campo virtual para senha em texto puro (não vai para o banco)

    /**
     * Retorna o nome da tabela no banco de dados
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * IdentityInterface: encontra usuário pelo ID
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * IdentityInterface: encontra usuário pelo access token (usado em APIs)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Encontra usuário pelo nome de usuário (login)
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * IdentityInterface: retorna o ID do usuário
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * IdentityInterface: retorna a authKey (chave de autenticação)
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * IdentityInterface: valida a authKey
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Valida a senha informada pelo usuário no login
     */
    public function validatePassword($password)
    {
        // Usa a função de hash do Yii2 para validar a senha digitada com o hash salvo
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    // Regras de validação dos campos do formulário
    public function rules()
    {
        return [
            [['username', 'role'], 'required', 'message' => 'Este campo é obrigatório.'],
            [['created_at', 'updated_at'], 'integer', 'message' => 'Informe um valor inteiro.'],
            [['username', 'password_hash', 'auth_key'], 'string', 'max' => 255, 'tooLong' => 'Máximo de 255 caracteres.'],
            [['role'], 'string', 'max' => 20, 'tooLong' => 'Máximo de 20 caracteres.'],
            [['password'], 'safe'], // senha não obrigatória na edição
        ];
    }

    // Nomes amigáveis para os campos (usados nos formulários e telas)
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuário',
            'password' => 'Senha',
            'password_hash' => 'Senha (hash)',
            'auth_key' => 'Chave de Autenticação',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
            'role' => 'Perfil',
        ];
    }

    /**
     * Relacionamento: retorna as movimentações realizadas por este usuário
     */
    public function getMovements()
    {
        // Um usuário pode ter várias movimentações de estoque
        return $this->hasMany(StockMovement::class, ['user_id' => 'id']);
    }
}
