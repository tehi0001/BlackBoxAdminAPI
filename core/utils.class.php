<?php
use Firebase\JWT\JWT as JWT;

class Utils {

    public static function get_db_object(): Database {
        require_once 'conf/db.php';
        return new Database($db_host, $db_user, $db_password, $db_name);
    }

    public static function hash_password(string $password): string {
        return password_hash($password, PASSWORD_ARGON2I);
    }

    public static function verify_password(string $password, string $password_hash): bool {
        return password_verify($password, $password_hash);
    }

    public static function generate_session_token(array $data): string {
        require 'conf/jwt.php';

        $payload = array(
            "iss" => "https://blackbox.timothyehimen.com",
            "aud" => "https://blackbox.timothyehimen.com",
            "alg" => "HS512",
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + 10000,
            "data" => $data
        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        $jwt = JWT::encode($payload, $jwt_key);

        return $jwt;
    }

    private static function decode_auth_token(string $token) {
        require 'conf/jwt_key.php';

        try {
            $decoded = JWT::decode($token, $jwt_key, array("HS256"));
            return json_decode(json_encode($decoded), true); // Hack for converting deep element objects to assoc array
        }
        catch (Exception $e) {
            throw new $e;
        }
    }
}