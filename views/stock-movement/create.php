<?php
use yii\helpers\Html;

$this->title = 'Registrar Movimentação';
$this->params['breadcrumbs'][] = ['label' => 'Movimentações de Estoque', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-movement-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
        'users' => $users
    ]) ?>
</div>
<p><?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?></p> 