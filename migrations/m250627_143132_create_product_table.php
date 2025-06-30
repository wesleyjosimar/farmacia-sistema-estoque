<?php

use yii\db\Migration;

/**
 * Migration responsável por criar a tabela 'product' no banco de dados.
 * Aqui definimos os campos, tipos e restrições da tabela.
 */
class m250627_143132_create_product_table extends Migration
{
    /**
     * Método chamado ao aplicar a migration (cria a tabela)
     */
    public function safeUp()
    {
        // Cria a tabela 'product' com os campos abaixo
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(), // Chave primária auto-incremento
            'name' => $this->string(100)->notNull(), // Nome do produto (obrigatório)
            'description' => $this->text(), // Descrição do produto (opcional)
            'quantity' => $this->integer()->notNull(), // Quantidade em estoque (obrigatório)
            'price' => $this->decimal(10,2)->notNull(), // Preço do produto (obrigatório, 2 casas decimais)
            'created_at' => $this->integer(), // Data de criação (timestamp)
            'updated_at' => $this->integer(), // Data de atualização (timestamp)
        ]);
    }

    /**
     * Método chamado ao desfazer a migration (remove a tabela)
     */
    public function safeDown()
    {
        // Remove a tabela 'product' do banco de dados
        $this->dropTable('{{%product}}');
    }
}
