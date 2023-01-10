<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $model */
/** @var yii\widgets\ActiveForm $form */

$array = [
    ['id' => 'Active', 'name' => 'Hoạt Động'],
    ['id' => 'Inactive', 'name' => 'Khóa'],
    ['id' => 'Deleted', 'name' => 'Xóa'],
];
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="d-flex justify-content-center">

        <div class="mx-2">
            <?= $form->field($model, 'id') ?>
        </div>

        <div class="mx-2">
            <?= $form->field($model, 'username') ?>
        </div>

        <?php // $form->field($model, 'auth_key') 
        ?>

        <?php // $form->field($model, 'password_hash') 
        ?>

        <?php // $form->field($model, 'password_reset_token') 
        ?>

        <div class="mx-2">
            <?php echo $form->field($model, 'statusStr')->dropDownList(
                ArrayHelper::map($array,'id','name'),
                ['prompt' => 'Trạng thái']
                ) ?>
        </div>

        <?php // echo $form->field($model, 'created_at') 
        ?>

        <?php // echo $form->field($model, 'updated_at') 
        ?>

        <?php // echo $form->field($model, 'verification_token') 
        ?>

        <div class="form-group m-2 py-3">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>