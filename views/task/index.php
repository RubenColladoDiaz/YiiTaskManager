<?php

use yii\helpers\Html;

/** @var app\models\Task[] $tasks */

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">My Tasks</h2>
        <p class="text-muted small mb-0">Organize and track your daily priorities</p>
    </div>

    <?= Html::a(
        '<i class="bi bi-plus-lg me-1"></i> New Task',
        ['task/create'],
        ['class' => 'btn btn-primary rounded-pill px-3 shadow-sm']
    ) ?>
</div>

<?php if (empty($tasks)): ?>

    <div class="empty-state text-center py-5">
        <div class="empty-state-icon mb-3">
            <span class="fs-1 text-muted opacity-50">📋</span>
        </div>
        <h5 class="fw-semibold mb-2">No tasks yet</h5>
        <p class="text-muted mb-4">Create your first task to get started on your list.</p>

        <?= Html::a(
            'Create Task',
            ['task/create'],
            ['class' => 'btn btn-primary rounded-pill px-4']
        ) ?>
    </div>

<?php else: ?>

    <div class="task-list">
        <?php foreach ($tasks as $task): ?>

            <?php
            // Definir color del badge según prioridad
            $priorityClass = match ((int) $task->priority) {
                1 => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                2 => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                3, 4 => 'bg-danger-subtle text-danger border-danger-subtle',
                default => 'bg-info-subtle text-info border-info-subtle'
            };
            ?>

            <div class="task-card d-flex align-items-center justify-content-between p-3 mb-3">
                <div class="task-content pe-3">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h5 class="mb-0 fw-bold task-title">
                            <?= Html::encode($task->title) ?>
                        </h5>

                        <?php if ($task->category): ?>
                            <span class="badge bg-light text-dark border">
                                <?= Html::encode($task->category->name) ?>
                            </span>
                        <?php endif; ?>

                        <span class="badge border <?= $priorityClass ?>">
                            Priority <?= Html::encode($task->priority) ?>
                        </span>
                    </div>

                    <?php if (!empty($task->description)): ?>
                        <p class="text-secondary small mb-0 text-truncate max-w-500">
                            <?= Html::encode($task->description) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="task-actions d-flex gap-2">
                    <?= Html::a(
                        'Edit',
                        ['task/update', 'id' => $task->id],
                        ['class' => 'btn btn-sm btn-light border text-secondary shadow-2xs hover-primary']
                    ) ?>

                    <?= Html::a(
                        'Delete',
                        ['task/delete', 'id' => $task->id],
                        [
                            'class' => 'btn btn-sm btn-light border text-danger shadow-2xs hover-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this task?',
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

<?php endif; ?>