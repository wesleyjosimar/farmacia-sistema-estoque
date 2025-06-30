<?php
use yii\helpers\Html;
$this->title = 'Sistema de Controle de Farmácia';
$this->registerCss(<<<CSS
.dashboard-card {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    margin-bottom: 24px;
    border: none;
}
.dashboard-card .card-header {
    border-radius: 10px 10px 0 0;
    font-size: 18px;
    font-weight: 600;
    padding: 12px 20px;
}
.card-atalho {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    margin-bottom: 24px;
    border: none;
    background: #fff;
    transition: box-shadow 0.2s;
}
.card-atalho:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.13);
}
.card-atalho .btn {
    margin-top: 10px;
    font-weight: 500;
    border-radius: 6px;
}
.card-produtos-baixo {
    background: #fffde7;
    border-left: 8px solid #ffe082;
}
.card-produtos-baixo .card-header {
    background: #ffe082;
    color: #795548;
}
.card-produtos-vencer {
    background: #ffebee;
    border-left: 8px solid #ffcdd2;
}
.card-produtos-vencer .card-header {
    background: #ffcdd2;
    color: #b71c1c;
}
.card-info-sistema {
    background: #e3f2fd;
    border-left: 8px solid #90caf9;
}
.card-info-sistema .card-header {
    background: #90caf9;
    color: #1565c0;
}
.table-dashboard th {
    background: #f5f5f5;
    font-weight: 600;
    font-size: 15px;
}
.table-dashboard td, .table-dashboard th {
    padding: 8px 12px !important;
    vertical-align: middle !important;
}
.badge-estoque {
    background: #e53935;
    color: #fff;
    font-size: 15px;
    border-radius: 8px;
    padding: 6px 14px;
}
.badge-minimo {
    background: #ffc107;
    color: #333;
    font-size: 15px;
    border-radius: 8px;
    padding: 6px 14px;
}
.badge-dias {
    background: #d32f2f;
    color: #fff;
    font-size: 15px;
    border-radius: 8px;
    padding: 6px 14px;
}
CSS);
?>
<div class="site-dashboard" style="margin-top:30px;">
    <h1 class="text-center mb-2" style="font-weight:700;">Sistema de Controle de Farmácia</h1>
    <p class="text-center text-muted mb-4">Gerencie seu estoque de forma simples e eficiente</p>
    <div class="row mb-4">
        <div class="col-md-4 text-center">
            <div class="card card-atalho">
                <div class="card-body">
                    <h3 style="font-weight:600;"><i class="glyphicon glyphicon-th-list"></i> Produtos</h3>
                    <p>Cadastre e gerencie todos os produtos da farmácia</p>
                    <?= Html::a('Ver Produtos', ['/product/index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card card-atalho">
                <div class="card-body">
                    <h3 style="font-weight:600;"><i class="glyphicon glyphicon-transfer"></i> Movimentações</h3>
                    <p>Registre entradas e saídas do estoque</p>
                    <?= Html::a('Ver Movimentações', ['/stock-movement/index'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card card-atalho">
                <div class="card-body">
                    <h3 style="font-weight:600;"><i class="glyphicon glyphicon-stats"></i> Relatórios</h3>
                    <p>Visualize relatórios e estatísticas</p>
                    <?= Html::a('Ver Relatórios', ['/report/estoque'], ['class' => 'btn btn-info']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card dashboard-card card-produtos-baixo">
                <div class="card-header"><i class="glyphicon glyphicon-warning-sign"></i> Produtos com Estoque Baixo</div>
                <div class="card-body">
                    <?php if (empty($produtosBaixo)): ?>
                        <p class="text-muted">Nenhum produto com estoque baixo.</p>
                    <?php else: ?>
                        <table class="table table-bordered table-dashboard mb-0">
                            <thead>
                                <tr><th>Produto</th><th>Atual</th><th>Mínimo</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach ($produtosBaixo as $produto): ?>
                                <tr>
                                    <td><?= Html::encode($produto->name) ?></td>
                                    <td><span class="badge-estoque"><?= Html::encode($produto->quantity) ?></span></td>
                                    <td><span class="badge-minimo"><?= Html::encode($produto->minimum_stock) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card dashboard-card card-produtos-vencer">
                <div class="card-header"><i class="glyphicon glyphicon-time"></i> Produtos a Vencer <span style="font-size:14px; color:#b71c1c;">(próximos 30 dias)</span></div>
                <div class="card-body">
                    <?php if (empty($produtosVencer)): ?>
                        <p class="text-muted">Nenhum produto a vencer nos próximos 30 dias.</p>
                    <?php else: ?>
                        <table class="table table-bordered table-dashboard mb-0">
                            <thead>
                                <tr><th>Produto</th><th>Validade</th><th>Dias</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach ($produtosVencer as $produto): ?>
                                <tr>
                                    <td><?= Html::encode($produto->name) ?></td>
                                    <td><?= Html::encode(Yii::$app->formatter->asDate($produto->expiry_date)) ?></td>
                                    <td><span class="badge-dias">
                                        <?php
                                            $dias = (strtotime($produto->expiry_date) - strtotime(date('Y-m-d'))) / 86400;
                                            echo (int)$dias . ' dia' . ($dias > 1 ? 's' : '');
                                        ?>
                                    </span></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card dashboard-card card-info-sistema">
                <div class="card-header"><i class="glyphicon glyphicon-info-sign"></i> Informações do Sistema</div>
                <div class="card-body">
                    <p>Sistema desenvolvido para controle de estoque de farmácia.<br>
                    Tecnologias: PHP, Yii2 Framework, PostgreSQL, Bootstrap 3</p>
                </div>
            </div>
        </div>
    </div>
</div> 