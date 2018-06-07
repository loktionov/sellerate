<?php

use app\models\Rate;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

$message = 'Поднеси QR-код<br>чека к сканеру';
/** @var Rate $model */
if ($model->hasErrors()){
    $message = $model->getErrorSummary(false)[0];
} ?>
<H1 id="message">
    <?= $message; ?>
</H1>


<input type="text" id="qr-input" style="margin-left: -2000px">
<?php ActiveForm::begin(['id' => 'qr-scan', 'method' => 'post',]) ?>
<input type="hidden" id="desk_number" name="Rate[desk_number]">
<input type="hidden" id="check_number" name="Rate[check_number]">
<input type="hidden" id="date_purchase" name="Rate[date_purchase]">
<input type="hidden" id="total" name="Rate[total]">
<?php ActiveForm::end(); ?>
<script>
    $(document).ready(function () {
        $('#qr-input').focus();
    });
    $(document).on('blur', '#qr-input', function () {
        $('#qr-input').focus();
    });

    //е=20180425Е2054?ы=182ю41?ат=8710000101563436?ш=9576?аз=2295327241?т=1
    //t=20180425T2054&s=182.41&fn=8710000101563436&i=9576&fp=2295327241&n=1
    let regex = /^[t|е]=(\d{8}[T|Е]\d{4,8})(\?ы|&s)=(\d+[\.|ю]\d*)(\?ат|&fn)=(\d+)(\?ш|&i)=(\d+)(\?аз|&fp)=(\d+)(\?т|&n)=(\d+)$/i;
    $(document).on('keyup', '#qr-input', function (e) {
        let qr_input = $('#qr-input');
        //Если последний символ $
        if (e.keyCode === 13) {
            let match = qr_input.val().match(regex);
            qr_input.val('');
            if (match === null || match.length !== 12) {
                $('#message').html('Какой-то сбой,<br> поднеси еще раз');
            }
            let t = match[1].replace('Е', 'T'),
                s = match[3].replace('ю', '.'),
                fn = match[5],
                i = match[7],
                fp = match[9],
                n = match[11];

            $('#desk_number').val(fn);
            $('#check_number').val(i);
            $('#date_purchase').val(t);
            $('#total').val(s);
            $('#qr-scan').submit();
        }
    });
</script>
<style>
    body {
        background: url(/images/step1.jpg) no-repeat center;
        background-size: 100%;
    }
</style>