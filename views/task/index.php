<?php

use yii\helpers\Html;

/** @var app\models\Task[] $tasks */

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">My Tasks</h2>

    <?= Html::a(
        '+ New Task',
        ['task/create'],
        ['class' => 'btn btn-primary']
    ) ?>
</div>

<?php if (empty($tasks)): ?>

    <div class="alert alert-light border text-center py-5">
        <h5 class="mb-2">No tasks yet</h5>
        <p class="text-muted mb-3">Create your first task to get started.</p>

        <?= Html::a(
            'Create Task',
            ['task/create'],
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

<?php else: ?>

    <div class="list-group shadow-sm">

        <?php foreach ($tasks as $task): ?>

            <div class="list-group-item d-flex justify-content-between align-items-center py-3">

                <div>
                    <h5 class="mb-1 fw-semibold">
                        <?= Html::encode($task->title) ?>
                    </h5>
                    <h6>
                        <?= Html::encode($task->category->name) ?>
                    </h6>
                </div>

                <div class="d-flex gap-2">

                    <?= Html::a(
                        'Edit',
                        ['task/update', 'id' => $task->id],
                        ['class' => 'btn btn-outline-primary btn-sm']
                    ) ?>

                    <?= Html::a(
                        'Delete',
                        ['task/delete', 'id' => $task->id],
                        [
                            'class' => 'btn btn-outline-danger btn-sm',
                            'data' => [
                                'confirm' => 'Delete this task?',
                                'method' => 'post',
                            ],
                        ]
                    ) ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>