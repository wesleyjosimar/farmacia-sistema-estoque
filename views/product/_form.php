<?php
// Importa helpers do Yii para HTML e formulários
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="product-form">
    <?php $form = ActiveForm::begin(); // Inicia o formulário Yii ?>
    <!-- Campo para o nome do produto -->
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Nome do Produto') ?>
    <!-- Campo para a descrição do produto -->
    <?= $form->field($model, 'description')->textarea(['rows' => 3])->label('Descrição') ?>
    <!-- Campo para a quantidade em estoque -->
    <?= $form->field($model, 'quantity')->input('number')->label('Quantidade em Estoque') ?>
    <!-- Campo para o preço -->
    <?= $form->field($model, 'price')->input('number', ['step' => '0.01'])->label('Preço (R$)') ?>
    <!-- Campo para a data de validade -->
    <?= $form->field($model, 'expiry_date')->input('date')->label('Validade') ?>
    <!-- Campo para o estoque mínimo -->
    <?= $form->field($model, 'minimum_stock')->input('number')->label('Estoque Mínimo') ?>
    <!-- Campo para a categoria -->
    <?= $form->field($model, 'category')->textInput(['maxlength' => true])->label('Categoria') ?>
    <!-- Campo para o fabricante -->
    <?= $form->field($model, 'manufacturer')->textInput(['maxlength' => true])->label('Fabricante') ?>
    <!-- Campo para o lote -->
    <?= $form->field($model, 'batch')->textInput(['maxlength' => true])->label('Lote') ?>
    <!-- Campo para o código de barras -->
    <?= $form->field($model, 'barcode')->textInput(['maxlength' => true])->label('Código de Barras') ?>
    <div class="form-group">
        <!-- Botão de submit: muda o texto conforme é cadastro ou edição -->
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); // Finaliza o formulário ?> 