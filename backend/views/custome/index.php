<?php

use app\models\Employee;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Nhân viên';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="custome-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'label' => 'id',
                'format' => 'raw',
                'value' => function ( $data) {
                    return Html::a('E0'.$data['id'], 'view?id='.$data['id']);
                    print_r($data['id']) ;
                },
                'sortLinkOptions' => function ( $data) {
                    return $data['id'];
                },
            ],
            'name',
            'email:email',
            'phoneNumber',
            'department.name',
            'username',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>


</div>
