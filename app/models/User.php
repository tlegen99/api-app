<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public string $password = '';
    public string $password_confirm = '';

    public static function tableName()
    {
        return 'users';
    }

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    public function rules()
    {
        return [
            [['username', 'password', 'password_confirm'], 'required', 'message' => 'Введите данные'],
            ['username', 'string', 'max' => 60],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Это имя пользователя уже занято'],
            ['password', 'string', 'min' => 6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают"],
            [['password_hash', 'access_token'], 'safe']
        ];
    }

    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function generatePasswordHash()
    {
        if (!empty($this->password)) {
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        }
    }

    /**
     * @throws \yii\db\Exception
     * @throws Exception
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
