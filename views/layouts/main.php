<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

// CSS padrão do sistema (sem dark mode)
$this->registerCss(<<<CSS
body {
    background: #f8f9fa;
    color: #222;
}
.navbar-dark.bg-dark {
    background-color: #222 !important;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.navbar-dark.bg-dark .navbar-nav .nav-link, .navbar-dark.bg-dark .navbar-brand {
    color: #fff !important;
    font-weight: 500;
    font-size: 16px;
}
.navbar-dark.bg-dark .navbar-nav .nav-link.active, .navbar-dark.bg-dark .navbar-nav .nav-link:focus, .navbar-dark.bg-dark .navbar-nav .nav-link:hover {
    background: #337ab7 !important;
    color: #fff !important;
    border-radius: 6px;
}
.panel, .panel-default, .panel-info, .panel-warning, .panel-danger {
    background: inherit !important;
    color: inherit !important;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
.table {
    background: inherit !important;
    color: inherit !important;
}
CSS);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php $this->head() ?>
    <style>
    .table-sticky thead th { position: sticky; top: 0; background: #f8f9fa; z-index: 2; }
    .linha-par { background: #fff; }
    .linha-impar { background: #f3f6fa; }
    .alert-success, .alert-danger, .alert-warning, .alert-info {
        font-size: 1.1em;
        font-weight: 500;
        border-radius: 6px;
        box-shadow: 0 2px 8px #0001;
        margin-top: 10px;
    }
    </style>
    <script>
    // Ativa tooltips Bootstrap 5 globalmente
    document.addEventListener('DOMContentLoaded', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
    </script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?php if (!Yii::$app->user->isGuest): ?>
<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'Farmácia - Sistema de Estoque',
        'brandUrl' => ['/site/dashboard'],
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark bg-dark fixed-top',
            'style' => 'min-height:60px;'
        ],
    ]);
    $menuItemsLeft = [
        ['label' => 'Produtos', 'url' => ['/product/index']],
        ['label' => 'Movimentações', 'url' => ['/stock-movement/index']],
    ];
    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'admin') {
        $menuItemsLeft[] = ['label' => 'Logs de Auditoria', 'url' => ['/audit-log/index']];
    }
    $menuItemsLeft[] = [
        'label' => 'Relatórios',
        'items' => [
            ['label' => 'Estoque', 'url' => ['/report/estoque']],
            ['label' => 'Movimentações', 'url' => ['/report/movimentacoes']],
        ],
    ];
    $adminSubmenu = [
        ['label' => 'Usuários', 'url' => ['/user/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $adminSubmenu[] = ['label' => 'Entrar', 'url' => ['/site/login']];
    } else {
        $adminSubmenu[] = ['label' => 'Sair (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
    }
    $menuItemsRight = [
        [
            'label' => 'Administradores do Sistema',
            'items' => $adminSubmenu,
            'encode' => false,
        ],
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-lg-0'],
        'items' => $menuItemsLeft,
        'encodeLabels' => false,
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-lg-0'],
        'items' => $menuItemsRight,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>
</header>
<?php endif; ?>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Farmácia - Sistema de Estoque <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end">Desenvolvido com Yii2</div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
