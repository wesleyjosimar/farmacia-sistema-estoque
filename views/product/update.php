<?php
use yii\helpers\Html;

$this->title = 'Editar Produto: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>
<p><?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?></p> 