<?php

namespace App\Models;

include 'src/util/hash.php';
use App\Util\Hash;

class User
{
    private $id;
    private $username;
    private $givenname;
    private $surname;
    private $pronouns;
    private $email;

    private function __construct($username)
    {
        $this->username = $username;
        $this->load();
    }

    public static function exists($username)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public static function register($pronouns, $givenname, $surname, $email, $username, $password)
    {

        if ($username == "" || $password == "" || $email == "" || $givenname == "" || $surname == "") {
            return false;
        }

        global $conn;

        $stmt = $conn->prepare("INSERT INTO users (pronouns, givenname, surname, username, email, password_hash, salt) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $salt = Hash::salt(16);
        $password_hash = Hash::make($password, $salt);

        $stmt->bind_param("sssssss", $pronouns, $givenname, $surname, $username, $email, $password_hash, $salt);
        $stmt->execute();

        return true;
    }

    public static function login($username, $password)
    {

        if ($username == "" || $password == "") {
            return false;
        }

        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if (Hash::make($password, $user['salt']) == $user['password_hash']) {
                return true;
            }
        }
        return false;
    }

    public function load()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("i", $this->username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $this->id = $user['id'];
            $this->givenname = $user['givenname'];
            $this->surname = $user['surname'];
            $this->pronouns = $user['pronouns'];
            $this->email = $user['email'];
        }
    }

    public function save() {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET pronouns = ?, givenname = ?, surname = ?, email = ? WHERE username = ?");
        $stmt->bind_param("sssss", $this->pronouns, $this->givenname, $this->surname, $this->email, $this->username);
        $stmt->execute();
    }
}