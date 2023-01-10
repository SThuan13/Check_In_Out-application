<?php

use app\models\Attendance;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AttendanceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Chấm công';
$this->params['breadcrumbs'][] = $this->title;
// echo "<pre>";
// print_r($searchModel);
?>
<div class="attendance-index">
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


  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel, 
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      'id',
      [
        'label' => 'Tên nhân viên',
        'attribute' => 'employeeName',
        'value' => 'detail.name',
      ],
      //'employee_id',
      'date',
      'timeIn',
      [
        'label' => 'Trạng thái vào',
        'attribute' => 'inStatus',
        'value' => function ($data) {
          if ($data['inStatus'] === 1) return 'Đúng giờ';
          else if ($data['inStatus'] === 0) return 'Muộn giờ';
          
        }
      ],
      //'inStatus',
      'timeOut',
      [
        'label' => 'Trạng thái ra',
        'attribute' => 'outStatus',
        'value' => function ($data) {
          if ($data['outStatus'] === 1) return 'Đúng giờ';
          else if ($data['outStatus'] === 0) return 'Muộn giờ';
        }
      ],
      //'outStatus',
      [
        'class' => ActionColumn::className(),
        'urlCreator' => function ($action, Attendance $model, $key, $index, $column) {
          return Url::toRoute([$action, 'id' => $model->id]);
        }
      ],
    ],
  ]); ?>


</div>