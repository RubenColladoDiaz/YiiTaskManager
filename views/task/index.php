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
            // Prioridad
            $priorityClass = match ((int) $task->priority) {
                1 => 'bg-secondary-subtle text-secondary',
                2 => 'bg-warning-subtle text-warning-emphasis',
                3, 4 => 'bg-danger-subtle text-danger',
                default => 'bg-info-subtle text-info'
            };

            // Status
            $statusClass = match (strtolower((string) $task->status)) {
                'completed', 'completada', 'done' => 'bg-success text-white',
                'in_progress', 'en_proceso', 'doing' => 'bg-primary text-white',
                'pending', 'pendiente' => 'bg-warning text-dark',
                default => 'bg-secondary text-white'
            };

            $statusLabel = ucfirst(str_replace('_', ' ', (string) $task->status));

            // Manejo y formato de due_date
            $isOverdue = false;
            $formattedDueDate = null;

            if (!empty($task->due_date)) {
                $dueDateTimestamp = strtotime($task->due_date);
                // Formato amigable: 13 Aug 2026, 15:30
                $formattedDueDate = date('d M Y, H:i', $dueDateTimestamp);

                // Comprobamos si está vencida (solo si no se ha completado)
                $isCompleted = in_array(strtolower((string) $task->status), ['completed', 'completada', 'done']);
                if ($dueDateTimestamp < time() && !$isCompleted) {
                    $isOverdue = true;
                }
            }
            ?>

            <div class="task-card p-3 mb-3">
                <div class="d-flex justify-content-between align-items-start gap-3">

                    <!-- Bloque principal: Estado + Título + Descripción -->
                    <div class="task-main flex-grow-1">
                        <div class="mb-2">
                            <?php if (!empty($task->status)): ?>
                                <span class="badge rounded-pill <?= $statusClass ?> mb-1">
                                    <?= Html::encode($statusLabel) ?>
                                </span>
                            <?php endif; ?>

                            <h5 class="fw-bold task-title mb-1">
                                <?= Html::encode($task->title) ?>
                            </h5>
                        </div>

                        <?php if (!empty($task->description)): ?>
                            <p class="text-secondary small mb-0 text-truncate max-w-600">
                                <?= Html::encode($task->description) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Acciones (Editar / Eliminar) -->
                    <div class="task-actions d-flex gap-2">
                        <?= Html::a(
                            'Edit',
                            ['task/update', 'id' => $task->id],
                            ['class' => 'btn btn-sm btn-light border text-secondary hover-primary']
                        ) ?>

                        <?= Html::a(
                            'Delete',
                            ['task/delete', 'id' => $task->id],
                            [
                                'class' => 'btn btn-sm btn-light border text-danger hover-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this task?',
                                    'method' => 'post',
                                ],
                            ]
                        ) ?>
                    </div>
                </div>

                <!-- Footer de la tarjeta: Metadatos secundarios (Categoría, Fecha Límite y Prioridad) -->
                <div class="task-footer d-flex align-items-center justify-content-between mt-3 pt-2 border-top text-muted fs-7">

                    <div class="d-flex align-items-center gap-3">
                        <!-- Categoría -->
                        <?php if ($task->category): ?>
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-folder2"></i>
                                <span><?= Html::encode($task->category->name) ?></span>
                            </div>
                        <?php endif; ?>

                        <!-- Prioridad -->
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-flag"></i>
                            <span class="badge <?= $priorityClass ?> font-monospace">
                                P<?= Html::encode($task->priority) ?>
                            </span>
                        </div>
                    </div>

                    <!-- Due Date -->
                    <?php if ($formattedDueDate): ?>
                        <div class="d-flex align-items-center gap-1 <?= $isOverdue ? 'text-danger fw-semibold' : '' ?>"
                            title="Due Date">
                            <i class="bi bi-calendar-event"></i>
                            <span><?= Html::encode($formattedDueDate) ?></span>
                            <?php if ($isOverdue): ?>
                                <span class="badge bg-danger-subtle text-danger ms-1">Overdue</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php endforeach; ?>
    </div>

<?php endif; ?>