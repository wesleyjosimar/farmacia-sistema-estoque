<?php
use yii\helpers\Html;
use yii\helpers\VarDumper;
$this->title = 'Logs de Auditoria';
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="table-responsive">
<table class="table table-bordered table-hover table-sticky">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Ação</th>
            <th>Modelo</th>
            <th>ID do Registro</th>
            <th>Data/Hora</th>
            <th>IP</th>
            <th>Detalhes</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($logs as $log): ?>
        <tr>
            <td><?= $log->id ?></td>
            <td><?= Html::encode($log->username) ?></td>
            <td><?= Html::encode($log->action) ?></td>
            <td><?= Html::encode($log->model) ?></td>
            <td><?= Html::encode($log->model_id) ?></td>
            <td><?= date('d/m/Y H:i:s', $log->created_at) ?></td>
            <td><?= Html::encode($log->ip) ?></td>
            <td><pre style="white-space:pre-wrap;word-break:break-all;max-width:400px;max-height:120px;overflow:auto;"><?php
                if ($log->data) {
                    $arr = json_decode($log->data, true);
                    echo Html::encode(VarDumper::export($arr));
                }
            ?></pre></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div> 