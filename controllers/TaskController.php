<?php

namespace app\controllers;

use app\models\Task;
use yii\web\Controller;

/**
 * Como se conecta el controller con la view?
 * Nosotros usamos http://localhost:8080/index.php?r=task/index
 * 
 * La parte importante es el "r=task/index" que indica que se debe usar el controller TaskController y la acción index.
 * 
 * En Yii hay que tener cuidado con la nomenclatura de los controllers y las acciones. 
 * Por ejemplo, si tenemos un controller llamado TaskController, la relacion con la acción index es "task/index". 
 * Si tuviéramos un controller llamado UserController, la relación con la acción index sería "user/index".
 * 
 * SIEMPRE tiene que empezar por action, y luego el nombre de la view con la primera letra en mayúscula.
 * Por ejemplo, actionIndex (views/task/index.php), actionView (views/task/view.php), actionCreate (views/task/create.php), etc.
 * 
 * URL
 * │
 * ▼
 * task/index
 * │
 * ▼
 * TaskController.php
 * │
 * ▼
 * actionIndex()
 * │
 * ▼
 * $this->render("index")
 * │
 * ▼
 * views/task/index.php
 * │
 * ▼
 * HTML al navegador
 * 
 * Si se muestra un menu de navegacion, es porque en la vista se está usando el layout main.php, 
 * que se encuentra en views/layouts/main.php.
 */

class TaskController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->all();

        return $this->render('index', [
            'tasks' => $tasks
        ]);
    }
}