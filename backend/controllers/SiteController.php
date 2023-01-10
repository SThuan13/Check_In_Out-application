<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use Yii\db\Query;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use app\models\Employee;
use app\models\Department;
use app\models\Group;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        
        //$Department = (new Query())->select('COUNT(*)')->from('department');
        $Department = Yii::$app->db->createCommand('SELECT COUNT(*) FROM department')
            ->queryScalar();
        $Group = Yii::$app->db->createCommand('SELECT COUNT(*) FROM `group`')
            ->queryScalar();
        if (!$Group) $Group = 0;
        // $Employee = Yii::$app->db->createCommand('SELECT COUNT(*) FROM employee')
        //     ->queryScalar();
        //if (!$Employee) $Employee = 0;

        return $this->render('index', [
            'department' => $Department,
            'group' => $Group,
            //'employee' => $Employee,
        ]);
    }

    
    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
