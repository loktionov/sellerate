<?php
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
?>
<?=  Alert::widget(); ?>
<div id="text">


</div>
<input type="text" id="input" style="margin-left: -2000px">
<?php ActiveForm::begin(['id' => 'qr-scan','method' => 'post',]) ?>
<input type="hidden" id="desk_number" name="Rate[desk_number]">
<input type="hidden" id="check_number" name="Rate[check_number]">
<?php ActiveForm::end(); ?>
<script>
    $(document).ready(function () {
        $('#input').focus();
    });
    $(document).on('blur', '#input', function () {
        $('#input').focus();
    });
    //е=20180425Е2054?ы=182ю41?ат=8710000101563436?ш=9576?аз=2295327241?т=1;
    //t=20180425T2054&s=182.41&fn=8710000101563436&i=9576&fp=2295327241&n=1$

    let regex = /^[t|е]=(\d{8}[T|Е]\d{4,8})(\?ы|&s)=(\d+[\.|ю]\d*)(\?ат|&fn)=(\d+)(\?ш|&i)=(\d+)(\?аз|&fp)=(\d+)(\?т|&n)=(\d+)[;|$]$/i;
    $(document).on('keyup', '#input', function () {
        let input = $('#input'), text = $('#text');
        //Если последний символ $
        if (/[\$|;]$/.test(input.val())) {
            let match = input.val().match(regex);
            input.val('');
            if (match  === null || match.length !== 12) {
                text.html(text.html() + '<br>wrong qr');
                return false;
            }
            let t = match[1],
                s = match[3].replace('ю', '.'),
                fn = match[5],
                i = match[7],
                fp = match[9],
                n = match[11];
            text.html(text.html() + '<br>' + fn + ' - ' + i);
            $('#desk_number').val(fn);
            $('#check_number').val(i);
            $('#qr-scan').submit();
        }
    });
</script>