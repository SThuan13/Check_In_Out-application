<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\EmployeeGroup $model */

$this->title = 'Update Employee Group: ' . $model->employee_id;
$this->params['breadcrumbs'][] = ['label' => 'Employee Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employee_id, 'url' => ['view', 'employee_id' => $model->employee_id, 'group_id' => $model->group_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employee-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
