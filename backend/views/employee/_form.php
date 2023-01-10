<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\Department;

/** @var yii\web\View $this */
/** @var app\models\Employee $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phoneNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(User::find()->all(), 'id', 'username'),
            ['prompt' => 'Chọn nguời dùng']
    ) ?>

    <?= $form->field($model, 'department_id')->dropDownList(
        ArrayHelper::map(Department::find()->all(), 'id', 'name'),
            ['prompt' => 'Chọn phòng ban'] 
    )?>

    <?php 
    // $form->field($model, 'department_id')->dropDownList(
    //     ArrayHelper::map(Department::find()->all(), 'id', 'name'),
    //     ['prompt' => 'Chọn phòng ban']
    // ) 
    ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
