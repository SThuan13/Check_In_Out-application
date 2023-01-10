<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\DetailGroup $model */

$this->title = $model->detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Detail Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="detail-group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'detail_id' => $model->detail_id, 'group_id' => $model->group_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'detail_id' => $model->detail_id, 'group_id' => $model->group_id], [
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
            'detail_id',
            'group_id',
        ],
    ]) ?>

</div>
