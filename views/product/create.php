<?php
// Importa helper do Yii para HTML
use yii\helpers\Html;

// Define o título da página e o breadcrumb
$this->title = 'Cadastrar Produto';
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Título da página -->
<h1><?= Html::encode($this->title) ?></h1>
<!-- Renderiza o formulário de cadastro, reutilizando o arquivo _form.php -->
<?= $this->render('_form', ['model' => $model]) ?>
<!-- Botão para voltar à lista de produtos -->
<p><?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?></p> 