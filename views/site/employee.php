<style>
    body {
        background: url(/images/step2-employees.jpg) no-repeat center;
        background-size: 101%;
    }
</style>
<?php
/**
 * @var $model Employee
 */


use app\models\Employee;
use app\models\Rate;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var Rate $model */

$dataProvider = new ActiveDataProvider([
    'query' => Employee::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
$allEmployees = Employee::find()->all();
$splitedEmployees = array_chunk($allEmployees, 5);
?>
<div id="flex-gallery">
    <?php foreach ($splitedEmployees as $split): ?>
        <div class="flex-gallery-row">
            <?php foreach ($split as $employee): ?>
                <div class="flex-gallery-item" data-employee-id="<?= $employee->id ?>">
                    <?= Html::img(\yii::$app->params['imagesPath'] . $employee->photo,
                        ['data' => ['employee-id' => $employee->id], 'width' => 270, 'height' => 360]); ?>
                    <div style="text-align: center;">
                        <span class="last-name"><?= $employee->first_name ?></span>
                        <br>
                        <span class="first-name"><?= $employee->last_name ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php ActiveForm::begin(['id' => 'rate_form', 'method' => 'post',]); ?>
<input type="hidden" id="desk_number" name="Rate[desk_number]" value="<?= $model->desk_number; ?>">
<input type="hidden" id="check_number" name="Rate[check_number]" value="<?= $model->check_number; ?>">
<input type="hidden" id="total" name="Rate[total]" value="<?= $model->total; ?>">
<input type="hidden" id="date_purchase" name="Rate[date_purchase]" value="<?= $model->date_purchase; ?>">
<input type="hidden" id="employee_id" name="Rate[employee_id]">
<?php ActiveForm::end(); ?>
<script>
    $(document).on('click', '.flex-gallery-item img', function (e) {
        $('#employee_id').val($(e.target).data('employee-id'));
        $('#rate_form').submit();
    })
</script>
