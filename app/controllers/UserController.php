<?php

namespace app\controllers;

use app\dto\ProfileDto;
use app\models\User;
use Yii;
use yii\web\UnauthorizedHttpException;

class UserController extends BaseController
{
    public $modelClass = User::class;

    /**
     * @throws UnauthorizedHttpException
     */
    public function actionProfile()
    {
        if ($user = Yii::$app->user->identity) {
            $profileDto = new ProfileDto(
                $user->id,
                $user->username,
                $user->first_name,
                $user->last_name,
                $user->email,
                $user->phone,
                $user->created_at
            );

            return [
                'status' => 'success',
                'data' => $profileDto
            ];
        }

        throw new UnauthorizedHttpException('Пользователь не авторизован.');
    }
}