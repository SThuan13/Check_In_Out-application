<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DepartmentSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="department-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="d-flex justify-content-center ">
        <div class="mx-2">
            <?= $form->field($model, 'id') ?>
        </div>

        <div class="mx-2">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="mx-2">
            <?= $form->field($model, 'description') ?>
        </div>
        
        <div class="form-group m-2 py-3">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>