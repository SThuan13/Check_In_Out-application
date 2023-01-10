<?php

namespace backend\controllers;

use Yii;
use app\models\Attendance;
use app\models\Employee;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rbac;
use yii\db\Query;
use app\models\AttendanceSearch;

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
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['manageAttendanceRecords'],
                            // 'roleParams' => function() {
                            //     //return ['post' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                            // },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['createAttendanceRecord'],
                            // 'roleParams' => function() {
                            //     //return ['post' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                            // },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['updateAttendanceRecord'],
                            // 'roleParams' => function() {
                            //     //return ['post' => Post::findOne(['id' => Yii::$app->request->get('id')])];
                            // },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['view'],
                            'roles' => ['viewAttendanceRecord'],
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

        // $query = Attendance::find();

        // $user = Yii::$app->user->identity;
        // $userId = $user->id;
        // $employee = Employee::findOne(['user_id' => $userId]);
        // if ($employee != Null)
        // {
        //     $departmentId = $employee->attributes['department_id'];
        // }
        // $auth = Yii::$app->authManager;

        // $roleName = $auth->getRolesByUser($userId); 
        // if (array_key_exists('admin', $roleName)) 
        // { 
        //     //
        //     //echo 'yes a';

        // }
        // else if($auth->getAssignment('departmentManager', $userId) != Null )
        // {
        //     //
        //     //echo 'yes d M';
        //     $query = $query
        //                 ->where(['department_id' => $departmentId])
        //                 ->andWhere(['<>','employee_id', $employee->attributes['id']])
        //             ;
        // }
        // else {
        //     //echo "<pre>";
        //     //print_r($auth->getUserIdsByRole('departmentManager'));
        //     $ids = Employee::findAll(['user_id' => $auth->getUserIdsByRole('departmentManager')]);
        //     $strIds = '';
        //     foreach($ids as $id)
        //     {
        //         //echo
        //         $strIds .= $id->attributes['id']. ',';
        //     }
        //     //echo $strIds;
        //     //print_r($ids);
        //     //die();
        //     $groupId = $employee->getGroups()->one()->attributes['id'];
        //     // $query = (new Query())
        //     //     ->select(['attendance.id', 'department_id', 'attendance.employee_id', 'date', 'timeIn', 'inStatus', 'timeOut', 'outStatus' ])
        //     //     ->from(['attendance', 'employee_group'])
        //     //     ->where(['attendance.employee_id = employee_group.employee_id','employee_group.group_id' => $groupId])
        //     //     ->all()
        //     //     ;
        //     // $query = (new Query())
        //     // ->select(['attendance.id', 'department_id', 'attendance.employee_id', 'date', 'timeIn', 'inStatus', 'timeOut', 'outStatus' ])
        //     //     ->from(['attendance'])
        //     //     ->leftJoin('employee_group', 'attendance.employee_id = employee_group.employee_id')
        //     //     ->where(['employee_group.group_id' => $groupId])
        //     //     //->all()
        //     // ;
        //     //echo "<prev>";
        //     //echo $groupId;
        //     //print_r($query);

        //     $query = $query
        //         ->from(['attendance'])
        //         ->leftJoin('employee_group', 'attendance.employee_id = employee_group.employee_id')
        //         ->where(['employee_group.group_id' => $groupId])
        //         ->andWhere(['<>','attendance.employee_id', $employee->attributes['id']])
        //         ->andWhere(['NOT IN', 'attendance.employee_id', [$strIds]])
        //     ;
        // }
        //die();
        //if()

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     'pagination' => [
        //         'pageSize' => 50
        //     ],
        //     'sort' => [
        //         'defaultOrder' => [
        //             'id' => SORT_DESC,
        //         ]
        //     ],
        // ]);

        $searchModel = new AttendanceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel, 
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

    /**
     * Creates a new Attendance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Attendance();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) 
            {

                Yii::$app->session->setFlash('success', 'Tạo bản ghi chấm công thành công! ');
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                Yii::$app->session->setFlash('warning', 'Tạo bản ghi chấm công không thành công! ');
            }
        } else {
            $model->loadDefaultValues();
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Attendance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Chỉnh sửa bản ghi chấm công thành công! ');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Attendance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Xóa bản ghi chấm công thành công! ');
        return $this->redirect(['index']);
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
