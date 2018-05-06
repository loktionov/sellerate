<?php

namespace app\controllers;

use app\models\Employee;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\LoginForm;

class AdminController extends Controller
{
    public $layout = 'admin';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionEmployee()
    {
        return $this->render('employee');
    }

    public function actionCashdesk()
    {
        return $this->render('cash_desk');
    }

    public function actionAddemployee()
    {
        $model = new Employee();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save() && $model->upload()) {
                return Yii::$app->getResponse()->redirect(Url::to(['admin/employee']));
            }
        }
        return $this->render('employee_add', ['model' => $model]);
    }

    public function actionUpdateemployee($id)
    {
        $model = Employee::findOne(['id' => $id]);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save() && $model->upload()) {
                return Yii::$app->getResponse()->redirect(Url::to(['admin/employee']));
            }
        }
        return $this->render('employee_update', ['model' => $model]);
    }

    public function actionDeleteemployee($id)
    {
        $this->findModel($id)->delete();

        return Yii::$app->getResponse()->redirect(Url::to(['admin/employee']));
    }

    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
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

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
