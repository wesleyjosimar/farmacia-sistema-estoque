<?php

use yii\db\Migration;

class m250628_000000_add_role_to_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'role', $this->string(32)->notNull()->defaultValue('operador'));
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'role');
    }
} 