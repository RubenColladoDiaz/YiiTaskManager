<?php

namespace app\services;

use app\models\Task;
use app\models\Category;

use app\constants\TaskStatus;

class TaskService
{
    public function delete(Task $task): bool
    {
        return $task->delete() > 0;
    }

    public function save(Task $model, array $data): bool
    {
        return $model->load($data) && $model->save();
    }

    public function getAllTasks(): array
    {
        return Task::find()->orderBy(['priority' => SORT_DESC])->all();
    }

    public function findTaskById(int $id): ?Task // puede ser null
    {
        return Task::findOne($id);
    }

    public function findTasksByTitle(string $title): array
    {
        return Task::find()->where(['like', 'title', $title])->all();
    }

    public function getAllCategories(): array
    {
        return Category::find()->all();
    }

    public function getPendingTasks(): array
    {
        return Task::find()->where(['status' => TaskStatus::PENDING])->andWhere(['>=', 'priority', 2])->orderBy(['priority' => SORT_DESC])->limit(3)->all();
    }

    // Construir la consulta poco a poco, mas flexible
    private function queryExercice()
    {
        $query = Task::find();
        $query->where(['status' => 'pending']);
        $query->orderBy(['priority' => SORT_DESC]);
        $tasks = $query->all();

        return $tasks;
    }
}
/**
 * Yii::$app->db->transaction(function () {
        // varias operaciones
    });
 */