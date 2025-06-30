<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Movimentações de Estoque';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-movement-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Registrar Movimentação', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-sticky'],
        'rowOptions' => function($model, $key, $index, $grid) {
            return ['class' => $index % 2 === 0 ? 'linha-par' : 'linha-impar'];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['style' => 'width:40px;']],
            [
                'attribute' => 'product_id',
                'value' => function($model) {
                    return $model->product ? $model->product->name : '(não encontrado)';
                },
                'label' => 'Produto',
                'filterInputOptions' => ['placeholder' => 'Produto...', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return $model->user ? $model->user->username : '(não encontrado)';
                },
                'label' => 'Usuário',
                'filterInputOptions' => ['placeholder' => 'Usuário...', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'type',
                'label' => 'Tipo',
                'value' => function($model) {
                    return $model->type ? $model->type : '(não definido)';
                },
                'filterInputOptions' => ['placeholder' => 'Tipo...', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'reason',
                'label' => 'Motivo',
                'value' => function($model) {
                    return $model->reason ? $model->reason : '(não definido)';
                },
                'filterInputOptions' => ['placeholder' => 'Motivo...', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'quantity',
                'label' => 'Quantidade',
                'headerOptions' => ['style' => 'width:80px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'filterInputOptions' => ['placeholder' => 'Qtd.', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Data',
                'value' => function($model) {
                    return $model->created_at ? date('d/m/Y H:i', $model->created_at) : '(não definido)';
                },
                'headerOptions' => ['style' => 'width:120px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'filterInputOptions' => ['placeholder' => 'dd/mm/aaaa', 'class' => 'form-control'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Ações',
                'headerOptions' => ['style' => 'width:110px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                'template' => '<div class="btn-group" role="group">{view}{update}{delete}</div>',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'Visualizar', 'data-bs-toggle' => 'tooltip', 'class' => 'btn btn-xs btn-info', 'style' => 'margin:0 2px;'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-edit"></i>', $url, [
                            'title' => 'Editar', 'data-bs-toggle' => 'tooltip', 'class' => 'btn btn-xs btn-warning', 'style' => 'margin:0 2px;'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title' => 'Excluir', 'data-bs-toggle' => 'tooltip', 'class' => 'btn btn-xs btn-danger',
                            'data' => [
                                'confirm' => 'Tem certeza que deseja excluir esta movimentação?',
                                'method' => 'post',
                            ],
                            'style' => 'margin:0 2px;'
                        ]);
                    },
                ],
            ],
        ],
        'summary' => 'Exibindo <b>{begin}-{end}</b> de <b>{totalCount}</b> movimentações',
        'emptyText' => 'Nenhuma movimentação encontrada.',
    ]);
    ?>
    <style>
    .table-sticky thead th { position: sticky; top: 0; background: #f8f9fa; z-index: 2; }
    .linha-par { background: #fff; }
    .linha-impar { background: #f3f6fa; }
    </style>
    <script>
    // Ativa tooltips Bootstrap 5
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
    </script>
</div> 