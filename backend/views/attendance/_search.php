<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AttendanceSearch $model */
/** @var yii\widgets\ActiveForm $form */

$array = [
    ['id' => '1', 'name' => 'Đúng giờ'],
    ['id' => '0', 'name' => 'Muộn giờ'],
];
?>
<div class="attendance-search ">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="d-flex justify-content-center">
        <div class="mx-2">
            <?php echo $form->field($model, 'id') ?>
        </div>

        <?php // $form->field($model, 'department_id') 
        ?>

        <div class="mx-2">
            <?php echo $form->field($model, 'employeeName') ?>
        </div>

        <div class="mx-2">
            <?php echo $form->field($model, 'date')->input('date') ?>
        </div>

        <div class="mx-2">
            <?= $form->field($model, 'fromDate')->input('date') ?>
        </div>

        <div class="mx-2">
            <?= $form->field($model, 'toDate')->input('date') ?>
        </div>



        <?php // $form->field($model, 'timeIn') 
        ?>

        
        <div class="mx-2">
            <?= $form->field($model, 'inStatus')->dropDownList(
                ArrayHelper::map($array,'id','name'),
                ['prompt' => 'Trạng thái']
                ) ?>
        </div>

        
        <?php // echo $form->field($model, 'timeOut') 
        ?>

        <div class="mx-2">
            <?= $form->field($model, 'outStatus')->dropDownList(
                ArrayHelper::map($array,'id','name'),
                ['prompt' => 'Trạng thái']
                ) ?> 
        </div>

    </div>

    <div class="d-flex justify-content-center">
        <div class="form-group m-2 ">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>