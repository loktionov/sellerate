<?php

use app\models\Employee;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

echo Html::a('Добавить', Url::to(['admin/addemployee']));

$dataProvider = new ActiveDataProvider([
    'query' => Employee::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'last_name',
        'first_name',
        'middle_name',
        [
            'attribute' => 'photo',
            'format' => 'html',
            'value' => function ($data) {
                return Html::img(\yii::$app->params['imagesPath'] . $data->photo, ['width' => 100]);
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]);
                    return Html::a($icon, Url::to(['admin/updateemployee', 'id' => $model->id]));
                },
                'delete' => function () {

                },
                'view' => function () {
                }
            ]
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'update' => function () {

                },
                'delete' => function ($url, $model, $key) {
                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                    return Html::a($icon, Url::to(['admin/deleteemployee', 'id' => $model->id]));
                },
                'view' => function () {
                }
            ]
        ],
    ],
]);