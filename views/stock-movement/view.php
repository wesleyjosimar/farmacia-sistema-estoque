<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Movimentação #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Movimentações de Estoque', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-movement-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir esta movimentação?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'product_id',
                'label' => 'Produto',
                'value' => $model->product ? $model->product->name : '(não encontrado)'
            ],
            [
                'attribute' => 'quantity',
                'label' => 'Quantidade',
            ],
            [
                'attribute' => 'type',
                'label' => 'Tipo',
                'value' => $model->type ? $model->type : '(não definido)'
            ],
            [
                'attribute' => 'reason',
                'label' => 'Motivo',
                'value' => $model->reason ? $model->reason : '(não definido)'
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Data',
                'value' => $model->created_at ? date('d/m/Y H:i', $model->created_at) : '(não definido)'
            ],
        ],
    ]) ?>
</div>
<p><?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?></p> 