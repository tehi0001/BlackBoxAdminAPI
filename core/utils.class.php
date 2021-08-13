<?php

class Utils {

    public static function get_db_object(): Database {
        return new Database("mariadb", "dev", "BlackBox@123", "blackbox");
    }

    public static function hash_password(string $password): string {
        return password_hash($password, PASSWORD_ARGON2I);
    }

    public static function verify_password(string $password, string $password_hash): bool {
        return password_verify($password, $password_hash);
    }
}