<?php
/**
 * @var $model Employee
 */


use app\models\Employee;
use yii\bootstrap\Modal;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

Modal::widget();
$dataProvider = new ActiveDataProvider([
    'query' => Employee::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
$allEmployees = Employee::find()->all();
$splitedEmployees = array_chunk($allEmployees, 6);
?>
<div id="big-photo-modal" class="fade modal" role="dialog" tabindex="-1" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" style="float: left" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="thx" class="btn btn-primary">Поблагодарить</button>
            </div>
        </div>
    </div>
</div>
<div id="flex-gallery">
    <?php foreach ($splitedEmployees as $split): ?>
        <div class="flex-gallery-row">
            <?php foreach ($split as $employee): ?>
                <div class="flex-gallery-item">
                    <div data-toggle="modal" data-target="#big-photo-modal" data-photo="<?= $employee->photo ?>"
                         data-employee-id="<?= $employee->id ?>">
                        <?php
                        echo Html::img('/images/employees/' . $employee->photo, ['data' => ['id' => $employee->id], 'width' => 180, 'height' => 240]);

                        ?>
                        <div style="text-align: center;">
                            <span class="last-name"><?= $employee->first_name ?></span>
                            <br>
                            <span class="first-name"><?= $employee->last_name ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php ActiveForm::begin(['id' => 'rate_form', 'method' => 'post',]); ?>
    <input type="hidden" id="desk_number" name="Rate[desk_number]" value="<?= $model->desk_number; ?>">
    <input type="hidden" id="check_number" name="Rate[check_number]" value="<?= $model->check_number; ?>">
    <input type="hidden" id="employee_id" name="Rate[employee_id]">
<?php ActiveForm::end(); ?>
<script>

    $('#big-photo-modal').on('show.bs.modal', function (e) {
        let photo = $(e.relatedTarget).data('photo'), employeeId = $(e.relatedTarget).data('employee-id');
        $('#employee_id').val(employeeId);
        $('#big-photo-modal .modal-body').html('<img src="/images/employees/' + photo + '" width="600" height="800">');
    });

    $(document).ready(function () {
        $('#thx').click(function (e) {
            $('#rate_form').submit();
        })
    })
</script>
