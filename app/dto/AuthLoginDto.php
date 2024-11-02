<?php

namespace app\dto;

use yii\base\Model;

class AuthLoginDto extends Model
{
    public string $username = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Поле не может быть пустым.'],
            ['username', 'string', 'max' => 60],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать не менее 6 символов.'],
        ];
    }
}