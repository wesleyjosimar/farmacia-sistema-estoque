<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="stock-movement-form">
    <?php if ($model->hasErrors()): ?>
        <div class="alert alert-danger">
            <?php foreach ($model->getFirstErrors() as $error): ?>
                <div><?= $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'product_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($products, 'id', 'name'),
        ['prompt' => 'Selecione o produto']
    )->label('Produto') ?>
    <?= $form->field($model, 'user_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($users, 'id', 'username'),
        ['prompt' => 'Selecione o usuário']
    ) ?>
    <?= $form->field($model, 'quantity')->input('number')->label('Quantidade') ?>
    <?= $form->field($model, 'type')->dropDownList([
        'entrada' => 'Entrada',
        'saida' => 'Saída',
    ], ['prompt' => 'Selecione o tipo'])->label('Tipo de Movimentação') ?>
    <?= $form->field($model, 'reason')->dropDownList([
        'compra' => 'Compra',
        'venda' => 'Venda',
        'ajuste' => 'Ajuste',
        'devolucao' => 'Devolução',
        'perda' => 'Perda',
        'outro' => 'Outro',
    ], ['prompt' => 'Selecione o motivo'])->label('Motivo') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?> 