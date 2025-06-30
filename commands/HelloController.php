<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;
use Yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    /**
     * Cria ou atualiza o usuário admin com senha 'admin'.
     */
    public function actionAdmin()
    {
        $username = 'admin';
        $senha = 'admin';
        $user = User::findOne(['username' => $username]);
        if (!$user) {
            $user = new User();
            $user->username = $username;
            $user->created_at = time();
        }
        $user->password_hash = Yii::$app->security->generatePasswordHash($senha);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->role = 'admin';
        $user->updated_at = time();
        if ($user->save(false)) {
            echo "Usuário admin criado/atualizado com sucesso!\n";
        } else {
            echo "Erro ao salvar usuário admin.\n";
        }
    }
}
