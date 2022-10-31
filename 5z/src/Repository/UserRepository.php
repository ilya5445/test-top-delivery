<?php

namespace API\Repository;

class UserRepository {
    
    /**
     * Верификация пользователя
     *
     * @param string $login
     * @param string $password
     * @return void
     */
    public function userVerify(string $login, string $password) {

        // Тут запрос в БД 
        if ($login == 'testUser' && $password == 'testPass') {
            return [
                'id' => intval(1),
                'login' => $login,
            ];
        }

        return false;
    }

}
