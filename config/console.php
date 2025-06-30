<?php

// Carrega os parâmetros globais e a configuração do banco de dados
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

// Configurações principais da aplicação em modo console (usado para comandos, migrations, etc)
$config = [
    'id' => 'basic-console', // Identificador da aplicação console
    'basePath' => dirname(__DIR__), // Caminho base do projeto
    'bootstrap' => ['log'], // Componentes inicializados no início
    'controllerNamespace' => 'app\\commands', // Namespace padrão dos comandos
    'aliases' => [
        '@bower' => '@vendor/bower-asset', // Alias para pacotes Bower
        '@npm'   => '@vendor/npm-asset',   // Alias para pacotes NPM
        '@tests' => '@app/tests',          // Alias para a pasta de testes
    ],
    'components' => [
        // Sistema de cache (aqui usa arquivos)
        'cache' => [
            'class' => 'yii\\caching\\FileCache',
        ],
        // Configuração de logs (registros de erro e warning)
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\\log\\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        // Conexão com o banco de dados
        'db' => $db,
    ],
    'params' => $params, // Parâmetros globais
    /*
    // Exemplo de mapeamento de comandos customizados
    'controllerMap' => [
        'fixture' => [ // Comando para gerar dados fake
            'class' => 'yii\\faker\\FixtureController',
        ],
    ],
    */
];

// Configurações extras para ambiente de desenvolvimento
if (YII_ENV_DEV) {
    // Adiciona o módulo Gii (gerador de código)
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\\gii\\Module',
    ];
    // Adiciona o módulo de debug
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\\debug\\Module',
        // Pode liberar IPs específicos para acessar o debug
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
