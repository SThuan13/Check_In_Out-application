<?php

namespace backend\controllers;

use app\models\EmployeeGroup;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EmployeeGroupController implements the CRUD actions for EmployeeGroup model.
 */
class EmployeeGroupController extends Controller
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
                            'actions' => ['index', 'create', 'update', 'view', 'delete'],
                            'roles' => ['groupManager'],
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
     * Lists all EmployeeGroup models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => EmployeeGroup::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'employee_id' => SORT_DESC,
                    'group_id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmployeeGroup model.
     * @param int $employee_id Employee ID
     * @param int $group_id Group ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($employee_id, $group_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($employee_id, $group_id),
        ]);
    }

    /**
     * Creates a new EmployeeGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new EmployeeGroup();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'employee_id' => $model->employee_id, 'group_id' => $model->group_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EmployeeGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $employee_id Employee ID
     * @param int $group_id Group ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($employee_id, $group_id)
    {
        $model = $this->findModel($employee_id, $group_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'employee_id' => $model->employee_id, 'group_id' => $model->group_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EmployeeGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $employee_id Employee ID
     * @param int $group_id Group ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($employee_id, $group_id)
    {
        $this->findModel($employee_id, $group_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EmployeeGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $employee_id Employee ID
     * @param int $group_id Group ID
     * @return EmployeeGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($employee_id, $group_id)
    {
        if (($model = EmployeeGroup::findOne(['employee_id' => $employee_id, 'group_id' => $group_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
