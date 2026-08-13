<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Iniciar Sesión';
?>
<div class="site-login">
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <p>Por favor, llena los campos para entrar o crear tu cuenta:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group d-flex gap-2">
        <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

        <?= Html::submitButton('Crear cuenta', [
            'class' => 'btn btn-success',
            'name' => 'register-button',
            'formaction' => Url::to(['auth/register']),
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>