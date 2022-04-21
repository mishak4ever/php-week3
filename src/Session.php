<?php

namespace Base;

class Session {

    const USER_ID = 'user_id';

    private static $_instance;

    private function __construct() {
        session_start();
    }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function destroy() {
        session_destroy();
    }

    public function setUserId(int $user_id) {
        if (!is_int($user_id)) {
            throw new Exception('Error save user_id in session');
        }

        $_SESSION[self::USER_ID] = $user_id;
    }

    public function getUserId() {
        return $_SESSION[self::USER_ID] ?? null;
    }

}
