<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Attendance $model */
/** @var yii\widgets\ActiveForm $form */
if ($model->attributes['timeIn'] != "") $timeIn = $model->attributes['timeIn'];
else $timeIn = date('h:i');

$array = [
    ['id' => '1', 'name' => 'Đúng giờ'],
    ['id' => '0', 'name' => 'Muộn giờ'],
];
?>

<div class="attendance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(User::find()->all(), 'id', 'username'),
        ['prompt' => 'Chọn nhân viên']
    ) ?>


    <?= $form->field($model, 'date')->input('date', [
        'value' => date('Y-m-d')
    ]) ?>

    <?= $form->field($model, 'timeIn', [
        'inputOptions' =>
        [
            'class' => 'form-control',
            'type' => 'time',
            'value' => $timeIn
        ]
    ]) ?>

    <?= $form->field($model, 'inStatus')->dropDownList(
        ArrayHelper::map($array, 'id', 'name'),
        ['prompt' => 'Trạng thái']
    ) ?>

    <?= $form->field($model, 'timeOut')->input('time') ?>

    <?= $form->field($model, 'outStatus')->dropDownList(
        ArrayHelper::map($array, 'id', 'name'),
        ['prompt' => 'Trạng thái']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>