<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AuditLog;
use yii\filters\AccessControl;
use app\models\UserSearch;

/**
 * Trabalho de MVC - Programação 3
 * Aluno: Wesley Lima
 * Professor: Leandro Otavio Cordova Vieira
 * Unoesc - 2024/1
 *
 * Controller responsável pelo CRUD de usuários do sistema.
 * Implementa permissões por perfil e logs de auditoria.
 */
class UserController extends Controller
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
        // Operador não pode acessar nada relacionado a usuários
        if ($role === 'operador') {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta funcionalidade.');
        }
        // Gerente não pode excluir usuários
        if ($role === 'gerente' && $actionId === 'delete') {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para excluir usuários.');
        }
        return parent::beforeAction($action);
    }

    // Lista todos os usuários cadastrados
    public function actionIndex()
    {
        $searchModel = new UserSearch(); // Classe para busca e filtro
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); // Busca com filtros da tela
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    // Mostra os detalhes de um usuário específico
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // Cria um novo usuário
    public function actionCreate()
    {
        $model = new User();
        // Se os dados do formulário foram enviados
        if ($model->load(Yii::$app->request->post())) {
            // Se foi informado uma senha, gera o hash dela
            if (!empty($model->password)) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->password = null; // Limpa o campo password
            }
            // Gera uma chave de autenticação aleatória
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->created_at = time();
            $model->updated_at = time();
            // Salva o usuário com validação
            if ($model->save()) {
                // Registra a ação no log de auditoria
                \app\models\AuditLog::registrar('criar', 'User', $model->id, $model->attributes);
                Yii::$app->session->setFlash('success', 'Usuário cadastrado com sucesso!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $errors = $model->getFirstErrors();
                Yii::$app->session->setFlash('error', 'Erro ao cadastrar usuário: ' . implode(' ', $errors));
            }
        }
        // Se não salvou, exibe o formulário novamente
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // Atualiza um usuário existente
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // Se os dados do formulário foram enviados
        if ($model->load(Yii::$app->request->post())) {
            // Se foi informada uma nova senha, gera o hash dela
            if (!empty($model->password)) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->password = null; // Limpa o campo password
            }
            $model->updated_at = time();
            // Salva o usuário com validação
            if ($model->save()) {
                // Registra a edição no log de auditoria
                \app\models\AuditLog::registrar('editar', 'User', $model->id, $model->attributes);
                Yii::$app->session->setFlash('success', 'Usuário atualizado com sucesso!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $errors = $model->getFirstErrors();
                Yii::$app->session->setFlash('error', 'Erro ao atualizar usuário: ' . implode(' ', $errors));
            }
        }
        // Se não salvou, exibe o formulário novamente
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    // Exclui um usuário
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelData = $model->attributes; // Salva os dados antes de excluir para registrar no log
        $model->delete();
        \app\models\AuditLog::registrar('excluir', 'User', $id, $modelData);
        Yii::$app->session->setFlash('success', 'Usuário excluído com sucesso!');
        return $this->redirect(['index']);
    }

    // Função auxiliar para buscar um usuário pelo ID
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        // Se não encontrar, lança exceção de página não encontrada
        throw new NotFoundHttpException('The requested page does not exist.');
    }
} 