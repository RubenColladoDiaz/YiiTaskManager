<?php

namespace app\controllers;

use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\models\TaskSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use Yii;

use app\services\TaskService;
use app\constants\TaskStatus;

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
    private TaskService $taskService;

    public function __construct(
        $id,
        $module,
        TaskService $taskService,
        $config = []
    ) {
        $this->taskService = $taskService;

        parent::__construct($id, $module, $config);
    }

    /*
    @ → usuario autenticado.
    ? → usuario invitado.
    */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                            'view',
                        ],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'create',
                            'update',
                            'delete',
                            'search',
                            'active-data-provider',
                            'pending-tasks',
                            'search-advanced',
                        ],
                        'roles' => ['@'],
                    ],
                ],
            ],
            // No queremos que alguien haga un delete mediante peticion GET por url
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $tasks = $this->taskService->getAllTasks();

        return $this->render('index', [
            'tasks' => $tasks
        ]);
    }

    public function actionCreate()
    {
        $model = new Task();

        if ($this->taskService->save($model, $this->request->post())) {
            Yii::$app->session->setFlash('success', 'Task created successfully');
            return $this->redirect(['index']);
        }

        $categoryOptions = $this->getCategoryOptions();

        return $this->render('create', ['model' => $model, 'categoryOptions' => $categoryOptions]);
    }

    public function actionUpdate(int $id)
    {
        $model = $this->taskService->findTaskById($id);
        if ($model == null) {
            Yii::$app->session->setFlash('error', 'Tarea no encontrada');
            return $this->redirect(['index']);
        }

        if ($this->taskService->save($model, $this->request->post())) {
            Yii::$app->session->setFlash('success', 'Task updated successfully');
            return $this->redirect(['index']);
        }

        $categoryOptions = $this->getCategoryOptions();

        return $this->render('create', ['model' => $model, 'categoryOptions' => $categoryOptions]);
    }

    public function actionDelete(int $id)
    {
        $model = $this->taskService->findTaskById($id);

        if ($model == null) {
            Yii::$app->session->setFlash('error', 'Tarea no encontrada');
            return $this->redirect(['index']);
        }

        if ($this->taskService->delete($model)) {
            Yii::$app->session->setFlash(
                'success',
                'Task deleted successfully'
            );
        } else {
            Yii::$app->session->setFlash(
                'error',
                'Could not delete task'
            );
        }

        return $this->redirect(['index']);
    }

    public function actionView(int $id)
    {
        $model = $this->taskService->findTaskById($id);

        if ($model == null) {
            throw new NotFoundHttpException('Task not found');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionPendingTasks()
    {
        $tasks = $this->taskService->getPendingTasks();

        return $this->render('index', ['tasks' => $tasks]);
    }

    public function actionSearch()
    {
        $title = $this->request->get('title');

        if ($title === null) {
            return $this->render('search');
        }

        $tasks = $this->taskService->findTasksByTitle($title);

        return $this->render('index', [
            'tasks' => $tasks,
        ]);
    }

    private function getCategoryOptions()
    {
        $categories = $this->taskService->getAllCategories();
        $categoryOptions = ArrayHelper::map($categories, 'id', 'name');

        if ($categoryOptions == null) {
            Yii::$app->session->setFlash('error', 'Error con las categorias');
            return $this->redirect(['index']);
        }

        return $categoryOptions;
    }

    private function getStatusOptions()
    {
        return [
            TaskStatus::PENDING => 'Pending',
            TaskStatus::IN_PROGRESS => 'In Progress',
            TaskStatus::COMPLETED => 'Completed',
        ];
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