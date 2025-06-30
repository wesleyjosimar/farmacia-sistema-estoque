<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Relatório de Movimentações';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-movimentacoes">
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="text-muted">Visualize todas as movimentações de estoque registradas no sistema.</p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'product_id',
                'value' => function($model) {
                    return $model->product ? $model->product->name : '(não encontrado)';
                },
                'label' => 'Produto'
            ],
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return $model->user ? $model->user->username : '(não encontrado)';
                },
                'label' => 'Usuário'
            ],
            [
                'attribute' => 'type',
                'label' => 'Tipo',
                'value' => function($model) {
                    return $model->type ? $model->type : '(não definido)';
                }
            ],
            [
                'attribute' => 'reason',
                'label' => 'Motivo',
                'value' => function($model) {
                    return $model->reason ? $model->reason : '(não definido)';
                }
            ],
            [
                'attribute' => 'quantity',
                'label' => 'Quantidade',
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Data',
                'value' => function($model) {
                    return $model->created_at ? date('d/m/Y H:i', $model->created_at) : '(não definido)';
                }
            ],
        ],
        'summary' => 'Exibindo <b>{begin}-{end}</b> de <b>{totalCount}</b> movimentações',
        'emptyText' => 'Nenhuma movimentação encontrada.',
    ]);
    ?>
    <p>
        <?= Html::a('Exportar CSV', ['export-movimentacoes-csv'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Exportar PDF', ['export-movimentacoes-pdf'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Exportar XLSX', ['export-movimentacoes-xlsx'], ['class' => 'btn btn-success']) ?>
    </p>
</div> 