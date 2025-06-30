<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Relatório de Estoque';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-estoque">
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="text-muted">Visualize o estoque atual de todos os produtos cadastrados.</p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name:text:Produto',
            'quantity:text:Quantidade em Estoque',
            'minimum_stock:text:Estoque Mínimo',
            'expiry_date:date:Validade',
            'category:text:Categoria',
            'manufacturer:text:Fabricante',
            'batch:text:Lote',
            'barcode:text:Código de Barras',
        ],
        'summary' => 'Exibindo <b>{begin}-{end}</b> de <b>{totalCount}</b> produtos',
        'emptyText' => 'Nenhum produto encontrado.',
    ]);
    ?>
    <p>
        <?= Html::a('Exportar CSV', ['export-estoque-csv'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Exportar PDF', ['export-estoque-pdf'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Exportar XLSX', ['export-estoque-xlsx'], ['class' => 'btn btn-success']) ?>
    </p>
</div> 