<?php

namespace app\controllers;

use Yii;
use app\models\StockMovement;
use app\models\Product;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AuditLog;
use yii\filters\AccessControl;

class StockMovementController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $user = Yii::$app->user->identity;
        $role = $user->role ?? null;
        $actionId = $action->id;
        // Operador não pode excluir movimentação
        if ($role === 'operador' && $actionId === 'delete') {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para excluir movimentações.');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new \app\models\StockMovementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new StockMovement();
        if ($model->load(Yii::$app->request->post())) {
            $product = Product::findOne($model->product_id);
            if ($model->type === 'entrada') {
                $product->quantity += $model->quantity;
            } else if ($model->type === 'saida') {
                $product->quantity -= $model->quantity;
            }
            $product->save();
            $model->user_id = Yii::$app->user->id ?? 1; // fallback para user 1
            $model->created_at = time();
            if ($model->save()) {
                \app\models\AuditLog::registrar('criar', 'StockMovement', $model->id, $model->attributes);
                Yii::$app->session->setFlash('success', 'Movimentação registrada com sucesso!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $products = Product::find()->all();
        $users = User::find()->all();
        return $this->render('create', [
            'model' => $model,
            'products' => $products,
            'users' => $users,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \app\models\AuditLog::registrar('editar', 'StockMovement', $model->id, $model->attributes);
            Yii::$app->session->setFlash('success', 'Movimentação atualizada com sucesso!');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $products = Product::find()->all();
        $users = User::find()->all();
        return $this->render('update', [
            'model' => $model,
            'products' => $products,
            'users' => $users,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelData = $model->attributes;
        $model->delete();
        \app\models\AuditLog::registrar('excluir', 'StockMovement', $id, $modelData);
        Yii::$app->session->setFlash('success', 'Movimentação excluída com sucesso!');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = StockMovement::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
} 