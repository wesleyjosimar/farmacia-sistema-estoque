<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AuditLog;
use yii\filters\AccessControl;

/**
 * Trabalho de MVC - Programação 3
 * Aluno: Wesley Lima
 * Professor: Leandro Otavio Cordova Vieira
 * Unoesc - 2024/1
 *
 * Controller responsável pelo CRUD de produtos.
 * Implementa permissões por perfil e logs de auditoria.
 */
class ProductController extends Controller
{
    // Método que define comportamentos de acesso e restrição de métodos HTTP
    public function behaviors()
    {
        return [
            // Controle de acesso: só usuários autenticados podem acessar as ações principais
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // @ significa usuário logado
                    ],
                ],
            ],
            // Filtro para garantir que a exclusão só pode ser feita via POST
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    // Antes de executar qualquer ação, verifica permissões específicas por perfil
    public function beforeAction($action)
    {
        $user = Yii::$app->user->identity;
        $role = $user->role ?? null;
        $actionId = $action->id;
        // Operador só pode visualizar produtos
        if ($role === 'operador' && !in_array($actionId, ['index', 'view'])) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para esta ação.');
        }
        // Gerente não pode excluir produtos
        if ($role === 'gerente' && $actionId === 'delete') {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para excluir.');
        }
        return parent::beforeAction($action);
    }

    // Lista todos os produtos cadastrados
    public function actionIndex()
    {
        $searchModel = new \app\models\ProductSearch(); // Classe para busca e filtro
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); // Busca com filtros da tela
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    // Mostra os detalhes de um produto específico
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // Cria um novo produto
    public function actionCreate()
    {
        $model = new Product();
        // Se os dados do formulário foram enviados e salvos com sucesso
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Registra a ação no log de auditoria
            \app\models\AuditLog::registrar('criar', 'Product', $model->id, $model->attributes);
            Yii::$app->session->setFlash('success', 'Produto cadastrado com sucesso!');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        // Se não salvou, exibe o formulário novamente
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Atualiza um produto existente
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // Se os dados do formulário foram enviados e salvos com sucesso
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Registra a edição no log de auditoria
            \app\models\AuditLog::registrar('editar', 'Product', $model->id, $model->attributes);
            Yii::$app->session->setFlash('success', 'Produto atualizado com sucesso!');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        // Se não salvou, exibe o formulário novamente
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    // Exclui um produto
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelData = $model->attributes; // Salva os dados antes de excluir para registrar no log
        $model->delete();
        \app\models\AuditLog::registrar('excluir', 'Product', $id, $modelData);
        Yii::$app->session->setFlash('success', 'Produto excluído com sucesso!');
        return $this->redirect(['index']);
    }

    // Função auxiliar para buscar um produto pelo ID
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        // Se não encontrar, lança exceção de página não encontrada
        throw new NotFoundHttpException('The requested page does not exist.');
    }
} 