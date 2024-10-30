<?php

namespace api;

use Codeception\Util\HttpCode;

class RegisterCest
{
    public function registerUserSuccess(\ApiTester $I)
    {
        $data = [
            'username' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'password' => '123456',
            'password_confirm' => '123456',
            'email' => 'testuser@example.com',
            'phone' => '12345678910',
        ];

        // Отправка POST-запроса на /auth/register
        $I->sendPost('/auth/register', $data);

        $I->seeResponseCodeIs(200);

        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => 'success',
            'message' => 'Пользователь зарегистрирован.',
        ]);

        $I->seeResponseMatchesJsonType([
            'status' => 'string',
            'message' => 'string',
            'token' => 'string',
        ]);
    }
}
