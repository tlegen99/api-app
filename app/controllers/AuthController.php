<?php

namespace app\controllers;

use app\dto\UserRegisterDto;
use app\models\User;
use Yii;
use yii\db\Exception;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class AuthController extends ActiveController
{
    public $modelClass = User::class;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'except' => ['register'],
            'auth' => function (string $accessToken) {
                return User::findIdentityByAccessToken($accessToken);
            },
        ];

        return $behaviors;
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function actionRegister(): array
    {
        $userRegisterDto = new UserRegisterDto(Yii::$app->request->post());

        $user = new User();
        $user->username = $userRegisterDto->username;
        $user->password = $userRegisterDto->password;
        $user->password_confirm = $userRegisterDto->password_confirm;
        $user->generatePasswordHash();
        $user->generateAccessToken();

        if ($user->validate()) {
            if ($user->save()) {
                return [
                    'status' => 'success',
                    'message' => 'Пользователь зарегистрирован.',
                    'token' => $user->access_token
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
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findOne(['username' => $username]);
        if ($user && $user->validatePassword($password)) {
            $user->generateAccessToken();
            $user->save();

            return [
                'status' => 'success',
                'message' => 'Пользователь авторизован.',
                'token' => $user->access_token
            ];
        } else {

            return ['error' => 'Неверное имя пользователя или пароль.'];
        }
    }
}