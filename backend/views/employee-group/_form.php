<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Employee;
use app\models\Group;

/** @var yii\web\View $this */
/** @var app\models\EmployeeGroup $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="employee-group-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'group_id')->dropDownList(
        ArrayHelper::map(Group::find()->all(), 'id', 'name'),
        ['prompt' => 'Chọn nhóm']
    )?>

    <?= $form->field($model, 'employee_id')->dropDownList(
        ArrayHelper::map(Employee::find()->all(), 'id', 'name'),
        ['prompt' => 'Chọn nhân viên']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
