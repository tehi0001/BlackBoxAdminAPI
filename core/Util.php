<?php

require_once 'database.class.php';
require_once '../LiteRouter/http/response.class.php';

use \LiteRouter\Http\Response as Response;

class Util {

    public static function get_db_object( Response $response) {
        try {
            return new Database("mariadb", "dev", "BlackBox@123", "blackbox");
        } catch (Exception $e) {
            $response->status(500)->send($e->getMessage());
        }
    }

}