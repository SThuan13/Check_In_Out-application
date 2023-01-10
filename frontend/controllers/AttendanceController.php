<?php

namespace frontend\controllers;

use Yii;
use app\models\Attendance;
use app\models\Employee;
use app\models\Detail;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AttendanceController implements the CRUD actions for Attendance model.
 */
class AttendanceController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['login', 'error'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['logout'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['@'],
                            //'roles' => ['manageAttendanceRecords'],
                            // 'roleParams' => function() {
                            //     //return ['post' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                            // },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['@'],
                            //'roles' => ['createAttendanceRecord'],
                            // 'roleParams' => function() {
                            //     //return ['post' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                            // },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['@'],
                            //'roles' => ['updateAttendanceRecord'],
                            // 'roleParams' => function() {
                            //     //return ['post' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                            // },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['view'],
                            'roles' => ['@'],
                            //'roles' => ['viewAttendanceRecord'],
                            // 'roleParams' => function() {
                            //     //return ['post' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                            // },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['check-in', 'check-out'],
                            'roles' => ['@'],
                            //'roles' => ['viewAttendanceRecord'],
                            // 'roleParams' => function() {
                            //     //return ['post' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                            // },
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Attendance models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $userId = $user->id;
        //$employeeId = Employee::findOne(['user_id' => $userId])->attributes['id'];
        $check = 0;

        $attendance = Attendance::findOne(['user_id' => $userId, 'date' => date('Y-m-d')]);
        
        // echo '<pre>'; 

        // print_r($attendance->attributes); 
        // echo '</pre>';
        // die();
        
        if ($attendance) 
        {
            if ($attendance->attributes['timeOut'] == '')
            {
                $check = -1;
            }
        }
        else {
            $check = 1 ;
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => Attendance::find()->where(['user_id' => $userId])->leftJoin('user', 'attendance.user_id = user.id'),
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'check' => $check,
        ]);
    }

    /**
     * Displays a single Attendance model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionCheckIn()
    {

        //search employee id
        $user = Yii::$app->user->identity;
        $userId = $user->id;

        $attendance = Attendance::findOne(['user_id' => $userId, 'date' => date('Y-m-d')]);
        if ($attendance) 
        {
            Yii::$app->session->setFlash('warning', 'Bạn đã check-in hôm nay! ');
            return $this->redirect('index');
        }

        //get current date in Asia/Bangkok format
        $timeIn = new \DateTime("now", new \DateTimeZone('Asia/Bangkok'));
        $timeIn = $timeIn->format('H:i');

        //inStatus
        $inStatus = 0;
        if (strtotime($timeIn) <= strtotime(date('H:i', 8))) $inStatus = 1;

        $model = new Attendance();

        $model->setAttribute('user_id', $userId);
        $model->setAttribute('date', date('Y-m-d'),);
        $model->setAttribute('timeIn', $timeIn);
        $model->setAttribute('inStatus', $inStatus);

        // echo '<pre>';
        // print_r($model);
        // print_r ($employee);
        // echo '</pre>';
        // die();

        if ($model->save())
        {
            Yii::$app->session->setFlash('info', 'Bạn đã check-in vào '.$timeIn. ' ngày ' .date('Y-m-d') );
        }

        return $this->redirect('index');
    }   

    public function actionCheckOut()
    {
        //search employee id
        $user = Yii::$app->user->identity;
        $userId = $user->id;
        $detail = Detail::findOne(['user_id' => $user])->attributes['id'];

        $attendance = Attendance::findOne(['user_id' => $userId, 'date' => date('Y-m-d')]);
        if (!$attendance) 
        {
            Yii::$app->session->setFlash('warning', 'Bạn đã check-out hôm nay! ');
            return $this->redirect('index');
        }
        // echo '<pre>';
        // print_r($attendance->attributes);
        // echo '</pre>';
        //die();

        $model = $this->findModel($attendance->attributes['id']);

        //get current date in Asia/Bangkok format
        $timeOut = new \DateTime("now", new \DateTimeZone('Asia/Bangkok'));
        $timeOut = $timeOut->format('H:i');

        //inStatus
        $outStatus = 0;
        if (strtotime($timeOut) <= strtotime(date('H:i', 17))) $outStatus = 1;


        $model->setAttribute('timeOut', $timeOut);
        $model->setAttribute('outStatus', $outStatus);

        // echo '<pre>';
        // print_r($model->attributes);
        // echo '</pre>';
        // die();

        if ($model->save())
        {
            Yii::$app->session->setFlash('info', 'Bạn đã check-out vào '.$timeOut. ' ngày ' .date('Y-m-d') );
        }
        return $this->redirect('index');
    }

    /**
     * Finds the Attendance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Attendance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attendance::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
