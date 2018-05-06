<?php

namespace app\controllers;

use app\models\Rate;
use yii\helpers\Url;
use yii\web\Controller;

class SiteController extends Controller
{

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
        $model = new Rate();
        if (\yii::$app->request->isPost) {
            if ($model->load(\yii::$app->request->post()) && $model->validate(['desk_number', 'check_number'])) {
                return \yii::$app->getResponse()->redirect(
                    Url::to(
                        [
                            'site/employee',
                            'desk_number' => $model->desk_number,
                            'check_number' => $model->check_number
                        ]
                    )
                );
            } else {
                $err = $model->getErrorSummary(false);
                \yii::$app->session->setFlash('error','Ошибка', false);
            }
        }
        return $this->render('index');
    }

    public function actionEmployee($desk_number, $check_number, $employee_id = null)
    {
        $model = new Rate();
        $model->check_number = $check_number;
        $model->desk_number = $desk_number;
        $model->employee_id = $employee_id;
        if (!empty($employee_id) && $model->save()) {
            return \yii::$app->getResponse()->redirect(Url::to(['site/index',]));
        }
        return $this->render('employee', ['model' => $model]);
    }
}
