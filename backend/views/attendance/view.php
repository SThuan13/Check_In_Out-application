<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Attendance $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="attendance-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'employee.name',
            'date',
            'timeIn',
            [
                'label' => 'Trạng thái vào',
                'value' => function ($model)
                {
                    if ($model['inStatus'] === 0) return 'Muộn giờ';
                    if ($model['inStatus'] === 1) return 'Đúng giờ';
                }
            ],
            'timeOut',
            [
                'label' => 'Trạng thái ra',
                'value' => function ($model)
                {
                    if ($model['outStatus'] === 0) return 'Muộn giờ';
                    if ($model['outStatus'] === 1) return 'Đúng giờ';
                }
            ],
        ],
    ]) ?>

</div>
