<?php
use yii\db\Migration;

class m250701_000000_create_audit_log_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('audit_log', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'username' => $this->string(64),
            'action' => $this->string(32)->notNull(),
            'model' => $this->string(64)->notNull(),
            'model_id' => $this->integer(),
            'data' => $this->text(),
            'ip' => $this->string(45),
            'created_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx_audit_log_user_id', 'audit_log', 'user_id');
        $this->createIndex('idx_audit_log_model', 'audit_log', 'model');
        $this->createIndex('idx_audit_log_model_id', 'audit_log', 'model_id');
    }
    public function safeDown()
    {
        $this->dropTable('audit_log');
    }
} 