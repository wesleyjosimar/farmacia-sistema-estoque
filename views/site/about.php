<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Sobre o Sistema';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= $this->title ?></h1>
    <p>Este sistema foi desenvolvido para o controle de estoque de farmácias, permitindo o cadastro, movimentação e acompanhamento de produtos de forma simples e eficiente.</p>
    <ul>
        <li><b>Tecnologias:</b> PHP, Yii2 Framework, PostgreSQL, Bootstrap</li>
        <li><b>Funcionalidades:</b> Cadastro de produtos, movimentações, relatórios, alertas de estoque baixo e validade, exportação de dados, controle de usuários e mais.</li>
        <li><b>Desenvolvedor:</b> <span style="color:#1976d2">Seu Nome ou Equipe</span></li>
    </ul>
    <p>Para dúvidas, sugestões ou suporte, utilize o menu de contato.</p>
</div>
