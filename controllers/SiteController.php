<?php

namespace app\controllers;

use app\models\Rate;
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

                if (empty($model->employee_id)) {
                    return $this->render('employee', ['model' => $model]);
                } else if ($model->save()) {
                    return $this->render('thx');
                }
            }
        }
        return $this->render('index', ['model' => $model]);
    }
}
