<?php

namespace api;

use ApiTester;
use Codeception\Util\HttpCode;

class RegisterCest
{
    public function registerUserSuccess(ApiTester $I): void
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

    public function registerWithoutUsername(ApiTester $I): void
    {
        $data = [
            'password' => '123456',
            'password_confirm' => '123456',
        ];

        $I->sendPost('/auth/register', $data);

        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'status' => 'error',
            'message' => [
                'username' => ['Поле не может быть пустым.']
            ],
        ]);
    }

    public function registerWithShortPassword(ApiTester $I): void
    {
        $data = [
            'username' => 'testuser',
            'password' => '123',
            'password_confirm' => '123',
        ];

        $I->sendPost('/auth/register', $data);

        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'status' => 'error',
            'message' => [
                'password' => ['Пароль должен содержать не менее 6 символов.'],
            ]
        ]);
    }

    public function registerWithPasswordsDontMatch(ApiTester $I): void
    {
        $data = [
            'username' => 'testuser',
            'password' => '123456',
            'password_confirm' => '1234567',
        ];

        $I->sendPost('/auth/register', $data);

        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'status' => 'error',
            'message' => [
                'password_confirm' => ['Пароли не совпадают.'],
            ]
        ]);
    }

    public function registerWithExistingUsername(ApiTester $I): void
    {
        $data = [
            'username' => 'user1',
            'password' => '123456',
            'password_confirm' => '123456',
        ];

        $I->sendPost('/auth/register', $data);

        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseContainsJson([
            'status' => 'error',
            'message' => [
                'username' => ['Это имя пользователя уже занято.'],
            ]
        ]);
    }

//    public function registerWithSQLInjection(ApiTester $I): void
//    {
//        $data = [
//            'username' => "testuser'; DROP TABLE users; --",
//            'password' => '123456',
//            'password_confirm' => '123456',
//        ];
//
//        $I->sendPost('/auth/register', $data);
//
//        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
//        $I->seeResponseContainsJson([
//            'status' => 'error'
//        ]);
//    }
}
