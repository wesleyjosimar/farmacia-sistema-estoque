<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class AuditLog extends ActiveRecord
{
    public static function tableName()
    {
        return 'audit_log';
    }

    public function rules()
    {
        return [
            [['action', 'model', 'created_at'], 'required'],
            [['user_id', 'model_id', 'created_at'], 'integer'],
            [['data'], 'string'],
            [['username', 'model'], 'string', 'max' => 64],
            [['action'], 'string', 'max' => 32],
            [['ip'], 'string', 'max' => 45],
        ];
    }

    /**
     * Registra um log de auditoria
     * @param string $action
     * @param string $model
     * @param int|null $model_id
     * @param array|null $data
     */
    public static function registrar($action, $model, $model_id = null, $data = null)
    {
        $user = Yii::$app->user->identity ?? null;
        $log = new self();
        $log->user_id = $user->id ?? null;
        $log->username = $user->username ?? null;
        $log->action = $action;
        $log->model = $model;
        $log->model_id = $model_id;
        $log->data = $data ? json_encode($data, JSON_UNESCAPED_UNICODE) : null;
        $log->ip = Yii::$app->request->userIP;
        $log->created_at = time();
        if (!$log->save()) {
            Yii::error('Erro ao salvar log de auditoria: ' . json_encode($log->getErrors()), __METHOD__);
        }
    }
} 