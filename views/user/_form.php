<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Usuário') ?>
    <?= $form->field($model, 'password')->passwordInput()->label('Senha') ?>
    <?= $form->field($model, 'role')->dropDownList([
        'admin' => 'Administrador',
        'gerente' => 'Gerente',
        'operador' => 'Operador',
    ], ['prompt' => 'Selecione o perfil'])->label('Perfil') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?> 