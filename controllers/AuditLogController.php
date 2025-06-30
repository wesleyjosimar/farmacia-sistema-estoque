<?php
namespace app\controllers;

use Yii;
use app\models\AuditLog;
use yii\web\Controller;
use yii\filters\AccessControl;

class AuditLogController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity && Yii::$app->user->identity->role === 'admin';
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $logs = AuditLog::find()->orderBy(['created_at' => SORT_DESC])->limit(200)->all();
        return $this->render('index', [
            'logs' => $logs,
        ]);
    }
} 