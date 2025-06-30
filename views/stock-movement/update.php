<?php
use yii\helpers\Html;

$this->title = 'Editar Movimentação';
$this->params['breadcrumbs'][] = ['label' => 'Movimentações de Estoque', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Movimentação #' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="stock-movement-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
<p><?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?></p> 