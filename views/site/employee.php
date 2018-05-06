<?php
/**
 * @var $model Employee
 */


use app\models\Employee;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

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
            'format' => 'raw',
            'value' => function ($data) {
                return Html::img('/images/thumb/' . $data->photo, ['data' => ['id' => $data->id]]);
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]);
                    return Html::a($icon, Url::to(['admin/updateemployee', 'id' => $model->id]));
                },
                'delete' => function ($url, $model, $key) {

                },
                'view' => function () {
                }
            ]
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'update' => function ($url, $model, $key) {

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
]); ?>
<form id="rate_form" method="get">
    <input type="hidden" id="desk_number" name="desk_number" value="<?= $model->desk_number; ?>">
    <input type="hidden" id="check_number" name="check_number" value="<?= $model->check_number; ?>">
    <input type="hidden" id="employee_id" name="employee_id">
</form>
<script>
    $(document).ready(function () {
        $('img[data-id]').click(function (e) {
            let id = $(e.target).data('id');
            $('#employee_id').val(id);
            $('#rate_form').submit();
        })
    })
</script>
