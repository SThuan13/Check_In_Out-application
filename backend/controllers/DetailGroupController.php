<?php

namespace backend\controllers;

use app\models\DetailGroup;
use app\models\DetailGroupSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DetailGroupController implements the CRUD actions for DetailGroup model.
 */
class DetailGroupController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
     * Lists all DetailGroup models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DetailGroupSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DetailGroup model.
     * @param int $detail_id Detail ID
     * @param int $group_id Group ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($detail_id, $group_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($detail_id, $group_id),
        ]);
    }

    /**
     * Creates a new DetailGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DetailGroup();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Tạo bản ghi chấm công thành công! ');
                return $this->redirect(['view', 'detail_id' => $model->detail_id, 'group_id' => $model->group_id]);
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
     * Updates an existing DetailGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $detail_id Detail ID
     * @param int $group_id Group ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($detail_id, $group_id)
    {
        $model = $this->findModel($detail_id, $group_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Chỉnh sửa thành công! ');
            return $this->redirect(['view', 'detail_id' => $model->detail_id, 'group_id' => $model->group_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DetailGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $detail_id Detail ID
     * @param int $group_id Group ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($detail_id, $group_id)
    {
        $this->findModel($detail_id, $group_id)->delete();
        Yii::$app->session->setFlash('success', 'Xóa bản ghi chấm công thành công! ');
        return $this->redirect(['index']);
    }

    /**
     * Finds the DetailGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $detail_id Detail ID
     * @param int $group_id Group ID
     * @return DetailGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($detail_id, $group_id)
    {
        if (($model = DetailGroup::findOne(['detail_id' => $detail_id, 'group_id' => $group_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
