<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = 'Erro';
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Ocorreu um erro ao processar sua solicitação.<br>
        Se o problema persistir, entre em contato com o administrador do sistema.
    </p>
    <p>
        <?= Html::a('Voltar para a página inicial', Yii::$app->homeUrl, ['class' => 'btn btn-default']) ?>
    </p>

</div>
