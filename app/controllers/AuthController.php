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
        $data = Yii::$app->request->post();
        $authRegisterDto = new AuthRegisterDto(
            $data['username'],
            $data['first_name'],
            $data['last_name'],
            $data['password'],
            $data['password_confirm'],
            $data['email'],
            $data['phone'],
        );

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

        if ($user->validate()) {
            if ($user->save()) {
                return [
                    'status' => 'success',
                    'message' => 'Пользователь зарегистрирован.',
                    'token' => $user->getAccessToken()
                ];
            } else {
                return $user->errors;
            }
        } else {
            return [
                'status' => 'error',
                'message' => $user->errors,
            ];
        }
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function actionLogin(): array
    {
        $data = Yii::$app->request->post();
        $authLoginDto = new AuthLoginDto(
            $data['username'],
            $data['password'],
        );

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