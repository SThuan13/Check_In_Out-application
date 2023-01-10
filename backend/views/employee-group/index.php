<?php

use app\models\EmployeeGroup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Employee Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-group-index">

    <div class="d-flex justify-content-between">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Tạo', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>
    


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'group.name',
            'employee.name',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, EmployeeGroup $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'employee_id' => $model->employee_id, 'group_id' => $model->group_id]);
                 }
            ],
        ],
    ]); ?>


</div>
