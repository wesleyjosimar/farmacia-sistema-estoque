<?php
/**
 * Classe responsável por registrar os arquivos CSS e JS principais do sistema.
 * Isso garante que todos os arquivos necessários para o layout e funcionalidades
 * sejam carregados em todas as páginas da aplicação.
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    // Caminho base para os arquivos (webroot = pasta web/)
    public $basePath = '@webroot';
    // URL base para acessar os arquivos
    public $baseUrl = '@web';
    // Lista de arquivos CSS que serão incluídos em todas as páginas
    public $css = [
        'css/site.css', // CSS principal do sistema
    ];
    // Lista de arquivos JS que serão incluídos em todas as páginas
    public $js = [
        // Pode adicionar arquivos JS aqui se precisar
    ];
    // Dependências: outros pacotes de assets que devem ser carregados antes
    public $depends = [
        'yii\web\YiiAsset', // JS/CSS padrão do Yii
        'yii\bootstrap5\BootstrapAsset' // Bootstrap 5 para layout responsivo
    ];
}
