<?php

// Arquivo de configuração do banco de dados
// Aqui definimos como o sistema vai se conectar ao banco (tipo, host, usuário, senha, etc)
return [
    'class' => 'yii\\db\\Connection', // Classe de conexão do Yii
    'dsn' => 'pgsql:host=localhost;port=5432;dbname=farmacia_db', // DSN: tipo do banco (pgsql), host, porta e nome do banco
    'username' => 'admin', // Usuário do banco de dados
    'password' => 'admin', // Senha do banco de dados
    'charset' => 'utf8',   // Codificação dos dados (UTF-8 é padrão para evitar problemas com acentuação)

    // Opções de cache de schema (usado em produção para melhorar performance)
    //'enableSchemaCache' => true, // Habilita cache do schema
    //'schemaCacheDuration' => 60, // Tempo do cache em segundos
    //'schemaCache' => 'cache',    // Componente de cache a ser usado
];
