<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Detail $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="detail-view">

    <div class="d-flex justify-content-between">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php
            // echo Html::a('Delete', ['delete', 'id' => $model->id], [
            //     'class' => 'btn btn-danger',
            //     'data' => [
            //         'confirm' => 'Are you sure you want to delete this item?',
            //         'method' => 'post',
            //     ],
            // ])
            ?>
        </p>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email:email',
            'phoneNumber',
            'user.username',
            'department.name',
            'group.name',
        ],
    ]) ?>

</div>