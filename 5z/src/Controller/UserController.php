<?php

namespace API\Controller;

use API\Repository\UserRepository;
use API\Service\JwtService;
use API\Service\UserService;

class UserController extends Controller {
    
    public function auth() {

        $userService = new UserService(new UserRepository());

        $login = $this->request['post']['login'];
        $password = $this->request['post']['password'];

        $user = $userService->authUser($login, $password);

        if (!$user) {
            http_response_code(401);
            echo json_encode(["message" => "Ошибка входа"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $jwtService = new JwtService();
        $jwt = $jwtService->jwtEncode($user, 600);

        if (!$jwt) {
            http_response_code(401);
            echo json_encode(["message" => "Ошибка входа"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        http_response_code(200);
    
        echo json_encode(
            [
                "message" => "Успешный вход в систему",
                "jwt" => $jwt
            ], 
            JSON_UNESCAPED_UNICODE
        );
        exit;

    }

    public function validateToken() {

        $jwt = $this->request['post']['jwt'];

        if (!$jwt) {
            http_response_code(401);
            echo json_encode(["message" => "Доступ запрещён"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        try {

            $jwtService = new JwtService();
            $jwtDecode = $jwtService->jwtDecode($jwt);

            http_response_code(200);

            echo json_encode([
                "message" => "Доступ разрешен",
                "data" => $jwtDecode->data
            ], JSON_UNESCAPED_UNICODE);
            exit;

        } catch (\Exception $th) {

            http_response_code(401);
            echo json_encode(["message" => "Токен не прошел проверку"], JSON_UNESCAPED_UNICODE);
            exit;

        }


    }
}
