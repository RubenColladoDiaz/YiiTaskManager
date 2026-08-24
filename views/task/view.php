<?php

use yii\widgets\DetailView;

/** @var app\models\Task $model */

?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title',
        'description:html',
        [
            'label' => 'Category',
            'value' => $model->category?->name,
        ],
        'created_at:datetime',
        'updated_at:datetime'
    ],
]) ?>