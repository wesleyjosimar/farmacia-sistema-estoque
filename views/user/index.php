<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Usuários';
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->user->identity->role ?? null;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($role === 'admin' || $role === 'gerente'): ?>
    <p>
        <?= Html::a('Cadastrar Usuário', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-sticky'],
        'rowOptions' => function($model, $key, $index, $grid) {
            return ['class' => $index % 2 === 0 ? 'linha-par' : 'linha-impar'];
        },
        'columns' => [
            [
                'attribute' => 'id',
                'label' => 'ID',
                'headerOptions' => ['style' => 'width:60px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'filterInputOptions' => ['placeholder' => 'ID', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'username',
                'label' => 'Usuário',
                'filterInputOptions' => ['placeholder' => 'Buscar usuário...', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'role',
                'label' => 'Perfil',
                'filterInputOptions' => ['placeholder' => 'Perfil...', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Criado em',
                'value' => function($model) {
                    return $model->created_at ? date('d/m/Y H:i', $model->created_at) : '';
                },
                'headerOptions' => ['style' => 'width:120px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'filterInputOptions' => ['placeholder' => 'dd/mm/aaaa', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Atualizado em',
                'value' => function($model) {
                    return $model->updated_at ? date('d/m/Y H:i', $model->updated_at) : '';
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
                'template' => ($role === 'admin' || $role === 'gerente') ? '<div class="btn-group" role="group">{view}{update}{delete}</div>' : '<div class="btn-group" role="group">{view}</div>',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'Visualizar', 'data-bs-toggle' => 'tooltip', 'class' => 'btn btn-xs btn-info', 'style' => 'margin:0 2px;'
                        ]);
                    },
                    'update' => function ($url, $model) use ($role) {
                        if ($role === 'admin' || $role === 'gerente') {
                            return Html::a('<i class="fa fa-edit"></i>', $url, [
                                'title' => 'Editar', 'data-bs-toggle' => 'tooltip', 'class' => 'btn btn-xs btn-warning', 'style' => 'margin:0 2px;'
                            ]);
                        }
                        return '';
                    },
                    'delete' => function ($url, $model) use ($role) {
                        if ($role === 'admin') {
                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                'title' => 'Excluir', 'data-bs-toggle' => 'tooltip', 'class' => 'btn btn-xs btn-danger',
                                'data' => [
                                    'confirm' => 'Tem certeza que deseja excluir este usuário?',
                                    'method' => 'post',
                                ],
                                'style' => 'margin:0 2px;'
                            ]);
                        }
                        return '';
                    },
                ],
            ],
        ],
        'summary' => 'Exibindo <b>{begin}-{end}</b> de <b>{totalCount}</b> usuários',
        'emptyText' => 'Nenhum usuário encontrado.',
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