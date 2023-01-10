<?php

use app\models\Attendance;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

// echo "<pre>";
// print_r ($dataProvider);

$url = "";
switch ($check) {
  case 0: {
      $url = Null;
      break;
    }
  case 1: {
      $url = "check-in";
      break;
    }
  case -1: {
      $url = "check-out";
      break;
    }
}

$this->title = 'Chấm công';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attendance-index">

  <div class="d-flex justify-content-between">
    <h1><?= Html::encode($this->title) ?></h1>


    <p>
      <?= Html::a('Chấm công', [$url], ['class' => 'btn btn-success']) ?>
    </p>

  </div>


  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      [
        'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
        'label' => 'id',
        'format' => 'raw',
        'value' => function ($data) {
          return Html::a($data['id'], 'view?id=' . $data['id']);
          //print_r('E0'.$data['id']) ;
        },
        // 'sortLinkOptions' => function ( $data) {
        //     return $data['id'];
        // },
      ],
      //'employee.name',
      'date',
      'timeIn',
      [
        'label' => 'Trạng thái vào',
        'attribute' => 'inStatus',
        'value' => function ($data) {
          if ($data['inStatus'] === 0) return 'Muộn giờ';
          if ($data['inStatus'] === 1) return 'Đúng giờ';
        }
      ],
      'timeOut',
      [
        'label' => 'Trạng thái vào',
        'attribute' => 'outStatus',
        'value' => function ($data) {
          if ($data['outStatus'] === 0) return 'Muộn giờ';
          if ($data['outStatus'] === 1) return 'Đúng giờ';
        }
      ],
    ],
  ]); ?>
</div>