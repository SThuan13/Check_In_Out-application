<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Department;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$statusArr = [
    ['id' => '10', 'name' => 'Hoạt động'],
    ['id' => '9', 'name' => 'Khóa'],
    ['id' => '0', 'name' => 'Xóa'],
]
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?php //  $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?php //  $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?php //  $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput()->dropDownList(
        ArrayHelper::map($statusArr, 'id', 'name'),
            ['prompt' => 'Trạng thái'] 
    )?> 

    <?php // $form->field($model, 'created_at')->textInput() ?>

    <?php // $form->field($model, 'updated_at')->textInput() ?>

    <?php // $form->field($model, 'verification_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($detail, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($detail, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($detail, 'phoneNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($detail, 'department_id')->dropDownList(
        ArrayHelper::map(Department::list()->all(), 'id', 'name'),
            ['prompt' => 'Chọn phòng ban'] 
    )?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
