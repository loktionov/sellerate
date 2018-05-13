<?php

use app\models\CashDesk;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

echo Html::a('Добавить', Url::to(['admin/addcashdesk']));

$dataProvider = new ActiveDataProvider([
    'query' => CashDesk::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'desk_number',
        'description',
        [
            'attribute' => 'date_add',
            'format' => ['date', 'php:d-m-Y H:i:s']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'update' => function ($url, $model, $key) {

                },
                'delete' => function ($url, $model, $key) {
                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                    return Html::a($icon, Url::to(['admin/deletecashdesk', 'id' => $model->id]));
                },
                'view' => function () {
                }
            ]
        ],
    ],
]);