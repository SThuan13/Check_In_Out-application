<?php

namespace backend\controllers;

use Yii;
use app\models\User;
use app\models\Employee;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rbac;
use yii\db\Query;

class CustomeController extends Controller
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
              'actions' => ['logout', 'index', 'view', 'create', 'update', 'delete'],
              'allow' => true,
              'roles' => ['@'],
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
    $query = (new Query())
      ->select(['employee.id', 'name', 'email', 'phoneNumber', 'department_id', 'username', 'status', 'created_at', 'updated_at'])
      ->from(['employee'])
      ->leftJoin('user', 'employee.user_id = user.id')
      //->all()
    ;

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
        // 'pagination' => [
        //     'pageSize' => 50
        // ],
        // 'sort' => [
        //     'defaultOrder' => [
        //         'id' => SORT_DESC,
        //     ]
        // ],
    ]);

    return $this->render('index', [
      'dataProvider' => $dataProvider,
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
  // public function actionCreate()
  // {
  //     $model = new Employee();

  //     if ($this->request->isPost) {
  //         if ($model->load($this->request->post()) && $model->save()) {

  //             return $this->redirect(['view', 'id' => $model->id]);
  //         }
  //     } else {
  //         $model->loadDefaultValues();
  //     }

  //     return $this->render('create', [
  //         'model' => $model,
  //     ]);
  // }

  /**
   * Updates an existing Attendance model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {

    // $model = $this->findModel($id);

    // if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //     return $this->redirect(['view', 'id' => $model->id]);
    // }

    // return $this->render('update', [
    //     'model' => $model,
    // ]);

    $employee = Employee::findOne($id);

    if (!$employee) {
      throw new NotFoundHttpException("The employee was not found.");
    }

    $user = User::findOne($employee->user_id);

    if (!$user) {
      throw new NotFoundHttpException("The user was not found.");
    }

    $employee->scenario = 'update';
    $user->scenario = 'update';

    if ($employee->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
      $isValid = $employee->validate();
      $isValid = $user->validate() && $isValid;
      if ($isValid) {
        $employee->save(false);
        $user->save(false);
        return $this->redirect(['costume/view', 'id' => $id]);
      }
    }

    $model = $this->findModel($id);

    return $this->render('update', [
      'model' => $employee,
      'user' => $user,
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
    $model = (new Query())
      ->select(['employee.id', 'name', 'email', 'phoneNumber', 'department_id', 'username', 'status', 'created_at', 'updated_at'])
      ->from(['employee'])
      ->leftJoin('user', 'employee.user_id = user.id')
      ->where(['employee.id' => $id])
      ->one();
    if ($model  !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
