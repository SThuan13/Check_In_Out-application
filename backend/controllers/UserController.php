<?php

namespace backend\controllers;

use Yii;
use app\models\User;
use app\models\Employee;
use app\models\Detail;
use yii\data\ActiveDataProvider;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SignupForm;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $createModel = new SignupForm();
        $detail = new Detail();

        if ($this->request->isPost) {
            // if ($model->load($this->request->post()) && $model->save()) {
            //     return $this->redirect(['view', 'id' => $model->id]);
            // }
            // echo "<pre>";
            // print_r($this->request->post());
            $model->load($this->request->post());
            //print_r($model);
            $createModel->username = $model->getAttribute('username');
            $createModel->password = $model->password;
            //echo $model->password;
            //$createModel->setAttributes('username', $model->getAttribute('username'));
            //$createModel->setAttributes('password', $model->getAttribute('password'));
            //print_r($createModel);
            $detail->load($this->request->post());
            
            //print_r($detail);
            //die();
            if ($detail->load($this->request->post()))
            {
                //echo "<pre>";
                //print_r($model);
                // print_r($createModel);
                // print_r($detail);
                // die();
                //$model->setAttribute('password_hash', Yii::$app->security->generatePasswordHash($model->getAttribute('password')));
                if ($createModel->signup())
                {
                    //$detail->setAttribute('user_id', $createModel->id);
                    $userId = User::findOne(['username' => $model->getAttribute('username')])->id;
                    $detail->setAttribute('user_id', $userId);
                    if ( $detail->save())
                    {
                        Yii::$app->session->setFlash('success', 'Tạo thành công! ');
                        return $this->redirect(['view', 'id' => $userId]);
                    }
                    // echo "<pre>";
                    // print_r($model);

                    // $detail->load($this->request->post());
                    
                    // print_r($detail);
                    // die();

                    
                }
            }
        } 
        // else {
        //     $model->loadDefaultValues();
        // }

        return $this->render('create', [
            'model' => $model,
            'detail' => $detail,
        ]);

        //Dùng signup form
        // $model = new SignupForm();

        // if ($this->request->isPost) {
        //     if ($model->load($this->request->post()) && $model->signup()) {
        //         $this->session->setFlash('success', 'Tạo thành công');
        //         return $this->redirect(['index']);
        //     } 
        //     // else {
        //     //     $model->loadDefaultValues();
        //     // }
        // }

        // return $this->render('signup', [
        //     'model' => $model,
        // ]);

    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model->setAttribute('password_hash', Yii::$app->security->generatePasswordHash($model->getAttribute('password')));

        $detail = Detail::findOne(['user_id' => $id]);
        if ($detail === Null) $detail = new Detail();
        $detail->setAttribute('user_id', $id);

        if ($this->request->isPost ) 
        {
            if ($model->load($this->request->post()) && $detail->load($this->request->post())   )
            {
                $model->setAttribute('password_hash', Yii::$app->security->generatePasswordHash($model->getAttribute('password')));
                if ($model->save() && $detail->save())
                {

                    Yii::$app->session->setFlash('success', 'Chỉnh sửa thành công! ');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'detail' => $detail,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Xoá thành công! ');
        } else {
            Yii::$app->session->setFlash('danger', 'Xoá không thành công thành công! ');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
