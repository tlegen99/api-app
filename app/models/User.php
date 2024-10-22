<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 *
 * @property int $id Идентификатор пользователя (primary key)
 * @property string $username Имя пользователя (максимум 60 символов)
 * @property string|null $first_name Имя пользователя (может быть null)
 * @property string|null $last_name Фамилия пользователя (может быть null)
 * @property string $password_hash Хеш пароля
 * @property string $access_token Уникальный токен доступа
 * @property string|null $email Электронная почта пользователя (может быть null)
 * @property string|null $phone Телефон пользователя (максимум 60 символов, может быть null)
 * @property int $created_at Время создания записи (Unix timestamp, по умолчанию текущее время)
 */

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public string $password = '';
    public string $password_confirm = '';

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'password', 'password_confirm'], 'required', 'message' => 'Введите данные'],
            [['username', 'first_name', 'last_name', 'phone'], 'string', 'max' => 60],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Это имя пользователя уже занято'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают"],
            ['password', 'string', 'min' => 6],
            [['password_hash', 'access_token', 'email'], 'string'],
            ['created_at', 'integer'],
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
        return static::findOne(['id' => $id]);
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
        return static::findOne(['username' => $username]);
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

    public function getAccessToken(): string
    {
        return $this->access_token;
    }
}
