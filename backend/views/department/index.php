<?php

use app\models\Department;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Phòng ban';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    <div class="d-flex justify-content-between">
        <div class="d-flex">
            <h1 class="mx-2">
                <?= Html::encode($this->title) ?>
            </h1>

            <button class="btn btn-primary m-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                Lọc
            </button>
        </div>

        <p>
            <?= Html::a('Tạo', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>

    <div class="collapse" id="collapseFilter">
        <div class="card card-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Department $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>