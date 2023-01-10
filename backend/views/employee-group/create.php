<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\EmployeeGroup $model */

$this->title = 'Create Employee Group';
$this->params['breadcrumbs'][] = ['label' => 'Employee Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
