<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;

class AuthController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'], // '@' significa usuarios autenticados
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'], // Solo permite logout mediante petición POST por seguridad
                ],
            ],
        ];
    }

    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginData = Yii::$app->request->post('LoginForm');

        if ($loginData) {
            $user = new User();
            $user->username = $loginData['username'] ?? '';
            $user->password_hash = Yii::$app->security->generatePasswordHash($loginData['password'] ?? '');
            $user->auth_key = Yii::$app->security->generateRandomString();

            if ($user->save()) {
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }

        return $this->redirect(['auth/login']);
    }
}