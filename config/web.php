<?php

// Carrega os parâmetros globais e a configuração do banco de dados
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

// Configurações principais da aplicação web
$config = [
    'id' => 'basic', // Identificador da aplicação
    'basePath' => dirname(__DIR__), // Caminho base do projeto
    'bootstrap' => ['log'], // Componentes que são inicializados no início
    'aliases' => [
        '@bower' => '@vendor/bower-asset', // Alias para pacotes Bower
        '@npm'   => '@vendor/npm-asset',   // Alias para pacotes NPM
    ],
    'components' => [
        // Configuração de requisições HTTP
        'request' => [
            // Chave secreta para validação de cookies (importante para segurança)
            'cookieValidationKey' => 'YH0VhGRgYJqC5nAkUtLL6OSdJDvT3ESX',
        ],
        // Sistema de cache (aqui usa arquivos)
        'cache' => [
            'class' => 'yii\\caching\\FileCache',
        ],
        // Gerenciamento de usuários e autenticação
        'user' => [
            'identityClass' => 'app\\models\\User', // Classe que representa o usuário
            'enableAutoLogin' => true, // Permite login automático
        ],
        // Tratamento de erros
        'errorHandler' => [
            'errorAction' => 'site/error', // Ação chamada em caso de erro
        ],
        // Configuração de envio de e-mails
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // Por padrão, os e-mails são salvos em arquivo (não enviados de verdade)
            'useFileTransport' => true,
        ],
        // Configuração de logs (registros de erro e warning)
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0, // Nível de detalhamento do log
            'targets' => [
                [
                    'class' => 'yii\\log\\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        // Conexão com o banco de dados
        'db' => $db,
        // Gerenciador de URLs amigáveis
        'urlManager' => [
            'enablePrettyUrl' => true, // URLs sem index.php
            'showScriptName' => false, // Esconde o nome do script
            'rules' => [], // Regras de roteamento (pode adicionar aqui)
        ],
        /*
        // Exemplo de configuração alternativa do urlManager
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params, // Parâmetros globais
];

// Configurações extras para ambiente de desenvolvimento
if (YII_ENV_DEV) {
    // Adiciona o módulo de debug
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\\debug\\Module',
        // Pode liberar IPs específicos para acessar o debug
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    // Adiciona o módulo Gii (gerador de código)
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\\gii\\Module',
        // Pode liberar IPs específicos para acessar o Gii
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
