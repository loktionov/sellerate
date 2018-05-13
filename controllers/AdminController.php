<?php

namespace app\controllers;

use app\models\CashDesk;
use app\models\Employee;
use app\models\Rate;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
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

    public $defaultAction = 'employee';

    public function actionEmployee()
    {
        return $this->render('employee');
    }

    public function actionCashdesk()
    {
        return $this->render('cash_desk');
    }

    public function actionRate()
    {
        $model = new Rate();
        if (!empty($_POST['Rate']['createTimeRange'])) {
            $model->createTimeRange = $_POST['Rate']['createTimeRange'];
        }
        $dataProvider = $model->searchByDate();
        return $this->render('rate', ['model' => $model, 'dataProvider' => $dataProvider]);
    }

    public
    function actionAddcashdesk()
    {
        $model = new CashDesk();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return Yii::$app->getResponse()->redirect(Url::to(['admin/cashdesk']));
            }
        }
        return $this->render('cash_desk_form', ['model' => $model]);
    }

    public
    function actionAddemployee()
    {
        $model = new Employee();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save() && $model->upload()) {
                return Yii::$app->getResponse()->redirect(Url::to(['admin/employee']));
            }
        }
        return $this->render('employee_add', ['model' => $model]);
    }

    public
    function actionUpdateemployee($id)
    {
        $model = Employee::findOne(['id' => $id]);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save() && $model->upload()) {
                return Yii::$app->getResponse()->redirect(Url::to(['admin/employee']));
            }
        }
        return $this->render('employee_update', ['model' => $model]);
    }

    public
    function actionDeleteemployee($id)
    {
        $this->findModel($id)->delete();

        return Yii::$app->getResponse()->redirect(Url::to(['admin/employee']));
    }

    public
    function actionDeletecashdesk($id)
    {
        $this->findModelCashDesk($id)->delete();

        return Yii::$app->getResponse()->redirect(Url::to(['admin/cashdesk']));
    }

    protected
    function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected
    function findModelCashDesk($id)
    {
        if (($model = CashDesk::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public
    function actionLogin()
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
    public
    function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
