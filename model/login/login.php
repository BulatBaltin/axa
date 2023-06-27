<?php

class Login {
    private $dbo;

    function __construct()
    {
        $this->dbo = new PDOAdmin();
        $this->dbo->Connect();
    }

    function setUser($uid, $pwd, $email) {
        $sql = 'INSERT INTO user (user_id, user_pwd, user_email) VALUES (?, ?, ?)';
        $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT); // encodePassword

    }

    function checkUser($uid, $email) {
        $sql = 'SELECT user_id FROM user WHERE user_id = ? OR email = ?';

    }
}