<?php

namespace app\services;

use app\models\Task;

class TaskService
{
    public function delete(Task $task): bool
    {
        return $task->delete() > 0;
    }
}