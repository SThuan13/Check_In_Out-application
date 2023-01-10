<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DetailGroup $model */

$this->title = 'Create Detail Group';
$this->params['breadcrumbs'][] = ['label' => 'Detail Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
