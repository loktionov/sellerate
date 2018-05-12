<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CashDesk */
/* @var $form ActiveForm */
?>
<div class="employee_form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'desk_number') ?>
    <?= $form->field($model, 'description') ?>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- employee_form -->
