<?php

namespace app\controllers;

use app\dto\AuthLoginDto;
use app\dto\AuthRegisterDto;
use app\models\User;
use Yii;
use yii\db\Exception;

class AuthController extends BaseController
{
    public $modelClass = User::class;

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function actionRegister(): array
    {
        $authRegisterDto = new AuthRegisterDto(Yii::$app->request->post());

        $user = new User();
        $user->username = $authRegisterDto->username;
        $user->first_name = $authRegisterDto->first_name;
        $user->last_name = $authRegisterDto->last_name;
        $user->password = $authRegisterDto->password;
        $user->password_confirm = $authRegisterDto->password_confirm;
        $user->email = $authRegisterDto->email;
        $user->phone = $authRegisterDto->phone;
        $user->generatePasswordHash();
        $user->generateAccessToken();
        $user->created_at = time();

        if (!$user->validate()) {
            Yii::$app->response->statusCode = 422;

            return [
                'status' => 'error',
                'message' => $user->errors,
            ];
        }

        if (!$user->save()) {
            Yii::$app->response->statusCode = 500;

            return [
                'status' => 'error',
                'message' => $user->errors,
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Пользователь зарегистрирован.',
            'token' => $user->getAccessToken()
        ];
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function actionLogin(): array
    {
        $authLoginDto = new AuthLoginDto(Yii::$app->request->post());

        $user = User::findOne(['username' => $authLoginDto->username]);
        if ($user && $user->validatePassword($authLoginDto->password)) {
            $user->generateAccessToken();
            $user->save(false);

            return [
                'status' => 'success',
                'message' => 'Пользователь авторизован.',
                'token' => $user->getAccessToken()
            ];
        } else {

            return ['error' => 'Неверное имя пользователя или пароль.'];
        }
    }
}