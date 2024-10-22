<?php

namespace app\controllers;

use app\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class BaseController extends ActiveController
{
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
}