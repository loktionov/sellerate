<?php

use kartik\daterange\DateRangePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model app\models\Rate */

$form = ActiveForm::begin();
echo DateRangePicker::widget([
    'model' => $model,
    'attribute' => 'createTimeRange',
    'convertFormat' => true,
    'pluginOptions' => [
        'timePicker' => false,
        'locale' => [
            'format' => 'd-m-Y'
        ]
    ],
    'options' => [
        'style' => 'float: left; width: 85%;',
        'autocomplete' => 'off'
    ]
]); ?>

<?= Html::submitButton('Показать', ['class' => 'btn btn-success', 'style' => 'float: right']); ?>
    <div style="clear: both"></div>
<?php ActiveForm::end(); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'last_name',
            'label' => 'Продавец',
            'value' => function ($data) {
                return $data['first_name'] . ' ' . $data['last_name'];
            }
        ],
        [
            'attribute' => 'c',
            'label' => 'Количество чеков'
        ],
        [
            'attribute' => 's',
            'label' => 'Сумма по чекам'
        ],
    ]
]);