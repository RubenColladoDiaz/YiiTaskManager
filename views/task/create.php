<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\Task $model */

?>

<div class="mx-auto" style="max-width: 700px;">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">New Task</h2>
        <p class="text-muted mb-0">
            Complete the information below to create a new task.
        </p>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'task-form',
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'title')->textInput([
        'maxlength' => true,
        'placeholder' => 'Enter a title...',
        'autofocus' => true,
    ]) ?>

    <?= $form->field($model, 'description')->textarea([
        'rows' => 5,
        'placeholder' => 'Describe the task...',
    ]) ?>

    <?= $form->field($model, 'priority')->textInput([
        'maxlength' => true,
        'placeholder' => 'Enter a number...',
        'autofocus' => true,
    ]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        $categoryOptions,
        ['prompt' => 'Seleccione una categoria']
    ) ?>

    <div class="d-flex justify-content-end gap-2 mt-4">

        <?= Html::a(
            'Cancel',
            ['task/index'],
            ['class' => 'btn btn-outline-secondary']
        ) ?>

        <?= Html::submitButton(
            'Save Task',
            ['class' => 'btn btn-primary']
        ) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>