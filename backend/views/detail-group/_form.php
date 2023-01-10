<?php

use app\models\Detail;
use app\models\Group;
use PHPUnit\Framework\Constraint\ArrayHasKey;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DetailGroup $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="detail-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->dropDownList(
        ArrayHelper::map(Group::find()->all(), 'id', 'name'),
        ['prompt' => 'Chọn nhóm']
    )?>

    <?= $form->field($model, 'detail')->dropDownList(
        ArrayHelper::map(Detail::find()->all(), 'id', 'name'),
        ['prompt' => 'Chọn nhân viên']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
