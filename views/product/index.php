<?php
// Importa helpers do Yii para HTML e GridView
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

// Define o título da página e o breadcrumb
$this->title = 'Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <!-- Título da página -->
    <h1><?= Html::encode($this->title) ?></h1>
    <!-- Botão para cadastrar novo produto -->
    <p>
        <?= Html::a('Cadastrar Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <!-- GridView: tabela dinâmica para listar produtos -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider, // Fonte de dados (produtos)
        'filterModel' => $searchModel,   // Modelo de busca/filtro
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-sticky'],
        // Alterna cor das linhas para facilitar leitura
        'rowOptions' => function($model, $key, $index, $grid) {
            return ['class' => $index % 2 === 0 ? 'linha-par' : 'linha-impar'];
        },
        'columns' => [
            // Coluna de numeração automática
            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['style' => 'width:40px;']],
            // Coluna do nome do produto, com filtro
            [
                'attribute' => 'name',
                'label' => 'Nome',
                'headerOptions' => ['style' => 'width:160px;'],
                'filterInputOptions' => ['placeholder' => 'Buscar nome...', 'class' => 'form-control'],
            ],
            // Coluna da descrição
            [
                'attribute' => 'description',
                'label' => 'Descrição',
                'headerOptions' => ['style' => 'width:180px;'],
                'filterInputOptions' => ['placeholder' => 'Buscar descrição...', 'class' => 'form-control'],
            ],
            // Coluna da quantidade
            [
                'attribute' => 'quantity',
                'label' => 'Quantidade',
                'headerOptions' => ['style' => 'width:80px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'filterInputOptions' => ['placeholder' => 'Qtd.', 'class' => 'form-control'],
            ],
            // Coluna do preço
            [
                'attribute' => 'price',
                'label' => 'Preço (R$)',
                'headerOptions' => ['style' => 'width:80px; text-align:right;'],
                'contentOptions' => ['style' => 'text-align:right;'],
                'format' => ['decimal', 2],
                'filterInputOptions' => ['placeholder' => 'Preço', 'class' => 'form-control'],
            ],
            // Coluna da validade
            [
                'attribute' => 'expiry_date',
                'label' => 'Validade',
                'headerOptions' => ['style' => 'width:90px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'format' => ['date', 'php:d/m/Y'],
                'filterInputOptions' => ['placeholder' => 'dd/mm/aaaa', 'class' => 'form-control'],
            ],
            // Coluna do estoque mínimo
            [
                'attribute' => 'minimum_stock',
                'label' => 'Estoque Mínimo',
                'headerOptions' => ['style' => 'width:80px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
            ],
            // Coluna da categoria
            [
                'attribute' => 'category',
                'label' => 'Categoria',
                'headerOptions' => ['style' => 'width:110px;'],
            ],
            // Coluna do fabricante
            [
                'attribute' => 'manufacturer',
                'label' => 'Fabricante',
                'headerOptions' => ['style' => 'width:110px;'],
            ],
            // Coluna do lote
            [
                'attribute' => 'batch',
                'label' => 'Lote',
                'headerOptions' => ['style' => 'width:70px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
            ],
            // Coluna do código de barras
            [
                'attribute' => 'barcode',
                'label' => 'Código de Barras',
                'headerOptions' => ['style' => 'width:120px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center; font-family:monospace;'],
            ],
            // Coluna de ações (visualizar, editar, excluir)
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Ações',
                'headerOptions' => ['style' => 'width:110px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                'template' => '<div class="btn-group" role="group">{view}{update}{delete}</div>',
                'buttons' => [
                    // Botão de visualizar
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'Visualizar', 'data-bs-toggle' => 'tooltip', 'class' => 'btn btn-xs btn-info', 'style' => 'margin:0 2px;'
                        ]);
                    },
                    // Botão de editar
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-edit"></i>', $url, [
                            'title' => 'Editar', 'data-bs-toggle' => 'tooltip', 'class' => 'btn btn-xs btn-warning', 'style' => 'margin:0 2px;'
                        ]);
                    },
                    // Botão de excluir
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title' => 'Excluir', 'data-bs-toggle' => 'tooltip', 'class' => 'btn btn-xs btn-danger',
                            'data' => [
                                'confirm' => 'Tem certeza que deseja excluir este produto?',
                                'method' => 'post',
                            ],
                            'style' => 'margin:0 2px;'
                        ]);
                    },
                ],
            ],
        ],
        // Texto de resumo e mensagem quando não há produtos
        'summary' => 'Exibindo <b>{begin}-{end}</b> de <b>{totalCount}</b> produtos',
        'emptyText' => 'Nenhum produto encontrado.',
    ]);
    ?>
    <style>
    /* Deixa o cabeçalho da tabela fixo ao rolar a tela */
    .table-sticky thead th { position: sticky; top: 0; background: #f8f9fa; z-index: 2; }
    /* Alterna cor das linhas */
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