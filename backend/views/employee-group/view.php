<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\EmployeeGroup $model */

$this->title = $model->employee_id;
$this->params['breadcrumbs'][] = ['label' => 'Employee Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="employee-group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'employee_id' => $model->employee_id, 'group_id' => $model->group_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'employee_id' => $model->employee_id, 'group_id' => $model->group_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'employee.name',
            'group.name',
        ],
    ]) ?>

</div>
