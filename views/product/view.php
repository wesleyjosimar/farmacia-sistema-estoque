<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir este produto?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name:text:Nome',
            'description:text:Descrição',
            'quantity:text:Quantidade em Estoque',
            'price:text:Preço (R$)',
            'expiry_date:date:Validade',
            'minimum_stock:text:Estoque Mínimo',
            'category:text:Categoria',
            'manufacturer:text:Fabricante',
            'batch:text:Lote',
            'barcode:text:Código de Barras',
        ],
    ]) ?>
</div>

<h3>Histórico de Movimentações</h3>
<?php if (empty($model->movements)): ?>
    <p class="text-muted">Nenhuma movimentação registrada para este produto.</p>
<?php else: ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Data</th>
            <th>Tipo</th>
            <th>Motivo</th>
            <th>Quantidade</th>
            <th>Usuário</th>
        </tr>
        <?php foreach ($model->movements as $mov): ?>
            <tr>
                <td><?= isset($mov->created_at) ? date('d/m/Y H:i', $mov->created_at) : '-' ?></td>
                <td><?= Html::encode($mov->type) ?></td>
                <td><?= Html::encode($mov->reason) ?></td>
                <td><?= Html::encode($mov->quantity) ?></td>
                <td><?= Html::encode($mov->user_id) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?> 