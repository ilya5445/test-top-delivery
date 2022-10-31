<?php

namespace API\Service;

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService {

    private $key;
    private $payload;

    function __construct() {
        $this->key = $_ENV['JWT_KEY'];

        $currentTime = time();

        $this->payload = [
            'iss' => $_ENV['JWT_ISS'],
            'aud' => $_ENV['JWT_AUD'],
            'iat' => $currentTime,
            'nbf' => $currentTime,
            'exp' => $currentTime + 10 * 60
        ];
    }

    /**
     * Кодирование токена
     *
     * @param array $data
     * @param integer $lifeTime секунды
     * @return void
     */
    public function jwtEncode(array $data = [], int $lifeTime = 600) {
        return JWT::encode(array_merge($this->payload, [
            'data' => $data, 
            'exp' => $this->payload['iat'] + $lifeTime
        ]), $this->key, 'HS256');
    }

    /**
     * Декодирование токена
     *
     * @param string $jwt
     * @return void
     */
    public function jwtDecode(string $jwt) {
        return JWT::decode($jwt, new Key($this->key, 'HS256'));
    }
    
}
