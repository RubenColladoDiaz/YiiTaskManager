<?php

namespace app\controllers;

use app\models\Category;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\models\TaskSearch;
use Yii;

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
        $tasks = Task::find()->orderBy(['priority' => SORT_DESC])->all();

        return $this->render('index', [
            'tasks' => $tasks
        ]);
    }

    public function actionCreate()
    {
        $model = new Task();

        $response = $this->managePost($model, 'Tarea creada correctamente');
        if ($response !== null) {
            return $response;
        }

        $categoryOptions = $this->getCategoryOptions();

        return $this->render('create', ['model' => $model, 'categoryOptions' => $categoryOptions]);
    }

    public function actionUpdate(int $id)
    {
        $model = Task::findOne($id);
        if ($model == null) {
            Yii::$app->session->setFlash('error', 'Tarea no encontrada');
            return $this->redirect(['index']);
        }

        $response = $this->managePost($model, 'Tarea actualizada correctamente');
        if ($response !== null) {
            return $response;
        }

        $categoryOptions = $this->getCategoryOptions();

        return $this->render('create', ['model' => $model, 'categoryOptions' => $categoryOptions]);
    }

    public function actionDelete(int $id)
    {
        $model = Task::findOne($id);
        if ($model == null) {
            Yii::$app->session->setFlash('error', 'Tarea no encontrada');
            return $this->redirect(['index']);
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionPendingTasks()
    {
        $tasks = Task::find()->where(['status' => 'pending'])->andWhere(['>=', 'priority', 2])->orderBy(['priority' => SORT_DESC])->limit(3)->all();

        return $this->render('index', ['tasks' => $tasks]);
    }

    public function actionSearch()
    {
        $title = Yii::$app->request->get('title');

        if ($title === null) {
            return $this->render('search');
        }

        $tasks = Task::find()->where(['like', 'title', $title])->all();

        return $this->render('index', [
            'tasks' => $tasks,
        ]);
    }

    private function managePost(Task $model, string $message)
    {
        if ($this->request->isPost) {
            // load asigna los campos recibidos a las propiedades correspondientes
            // de model. Por seguridad, solo se asignan los atributos definidos en
            // las rules
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', $message);

                return $this->redirect(['index']);
            }
        }

        return null;
    }

    private function getCategoryOptions()
    {
        $categories = Category::find()->all();
        $categoryOptions = ArrayHelper::map($categories, 'id', 'name');

        if ($categoryOptions == null) {
            Yii::$app->session->setFlash('error', 'Error con las categorias');
            return $this->redirect(['index']);
        }

        return $categoryOptions;
    }

    private function getStatusOptions()
    {
        $statusOptions = [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
        ];

        return $statusOptions;
    }

    private function getPriorityOptions()
    {
        $priorityOptions = [
            0 => 'Very Low',
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
            4 => 'Very High',
            5 => 'Essential',
        ];

        return $priorityOptions;
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

    public function actionActiveDataProvider()
    {
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);

        return $this->render('activeDataProvider', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearchAdvanced()
    {
        $searchModel = new TaskSearch();

        $dataProvider = $searchModel->search(
            Yii::$app->request->queryParams
        );

        $categories = $this->getCategoryOptions();
        $statuses = $this->getStatusOptions();
        $priorities = $this->getPriorityOptions();

        return $this->render('search-advanced', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'statuses' => $statuses,
            'priorities' => $priorities
        ]);
    }
}