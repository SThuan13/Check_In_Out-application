<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'phoneNumber')->textInput() ?>

    <?php //= $form->field($model, 'user_id')->textInput() ?>
    
    <?= $form->field($user, 'username')->textInput() ?>
    
    <?= $form->field($user, 'password')->textInput() ?>

    <?= $form->field($model, 'department_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
