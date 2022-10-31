
# 5z

Установка
```
cd /5z/
composer install
```

## Методы API

- Авторизация пользователя POST /auth/
- Проверка токена POST /validate-token

## Параметры для авторизации пользователя
```
{
    "login": "testUser", 
    "password": "testPass"
}
```

## Параметры для проверки токена
```
{
    "jwt": ""
}
```