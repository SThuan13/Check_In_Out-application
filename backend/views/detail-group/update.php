<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DetailGroup $model */

$this->title = 'Update Detail Group: ' . $model->detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Detail Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->detail_id, 'url' => ['view', 'detail_id' => $model->detail_id, 'group_id' => $model->group_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="detail-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
