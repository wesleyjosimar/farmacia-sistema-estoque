<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Entrar no Sistema';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-container" style="display:flex;justify-content:center;align-items:center;min-height:80vh;">
    <div style="width:100%;max-width:400px;background:#fff;padding:32px 28px 24px 28px;border-radius:12px;box-shadow:0 2px 16px #0001;">
        <h1 class="mb-3" style="font-weight:700;font-size:2.2rem;">Entrar no Sistema</h1>
        <p class="mb-4" style="color:#888;font-size:1.1rem;">Preencha os campos abaixo para acessar o sistema:</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Usuário']) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Senha']) ?>
            <?= $form->field($model, 'rememberMe')->checkbox(['style' => 'margin-top:10px;']) ?>
            <div class="form-group mt-3">
                <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary w-100', 'name' => 'login-button', 'style' => 'font-size:1.1rem;']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<style>
    body { background: #f8f9fa !important; }
    .login-container { min-height: 80vh; }
</style>
