### Регистрация пользователя

запрос:
~~~
http://api-app.local:2020/auth/register
~~~

данные:
```json
{
    "username": "egor_mart",
    "first_name": "Егор",
    "last_name": "Март",
    "password": "123456",
    "password_confirm": "123456",
    "email": "egor_mart@mail.ru",
    "phone": "345345345345"
}
```

### Авторизация

запрос:
~~~
http://api-app.local:2020/auth/login
~~~

В заголовке передаем токен который получили при регистрации:
Authorization Basic <токен>

данные:
```json
{
  "username": "egor_mart",
  "password": "123456"
}
```

### Апи запрос на получение данных профиля

запрос:
~~~
http://api-app.local:2020/user/profile
~~~

В заголовке передаем токен который получили при регистрации или при логине:
Authorization Basic <токен>

### Апи запрос на получение списка задач пользователя

запрос:
~~~
http://api-app.local:2020/task/list
~~~

В заголовке передаем токен который получили при регистрации или при логине:
Authorization Basic <токен>

### Апи запрос на создание задачи

запрос:
~~~
http://api-app.local:2020/task/create
~~~

В заголовке передаем токен который получили при регистрации или при логине:
Authorization Basic <токен>

передаваемые данные:
```json
{
    "user_id": 5,
    "title": "Тест задача 2",
    "body": "тестовый текст к задаче 2"
}
```