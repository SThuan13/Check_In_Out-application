<?php

use app\models\DetailGroup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\DetailGroupSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Detail Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detail-group-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Detail Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'detail.name',
            'group.name',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, DetailGroup $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'detail_id' => $model->detail_id, 'group_id' => $model->group_id]);
                 }
            ],
        ],
    ]); ?>


</div>
