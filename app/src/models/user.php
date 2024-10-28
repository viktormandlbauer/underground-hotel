<?php

require 'src/config/Database.php';
require 'src/util/Hash.php';

class User
{
    private $dbconn;
    private $id;
    public $role;
    public $username;
    public $givenname;
    public $surname;
    public $pronouns;
    public $email;
    public $telephone;
    public $country;
    public $postal_code;
    public $city;
    public $street;
    public $house_number;

    public function __construct($username)
    {
        $this->dbconn = self::getDBConnection();
        $this->username = $username;
    }

    public static function getDBConnection()
    {
        return Database::getInstance()->getConnection();
    }

    public static function exists_username($username)
    {
        $stmt = self::getDBConnection()->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public static function exists_email($email)
    {
        $stmt = self::getDBConnection()->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public static function register($pronouns, $givenname, $surname, $email, $username, $password)
    {

        if (!isset($pronouns, $givenname, $surname, $email, $username, $password)) {
            return false;
        }

        $stmt = self::getDBConnection()->prepare("INSERT INTO users ( pronouns, givenname, surname, username, email, password_hash, salt) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $salt = Hash::salt(16);
        $password_hash = Hash::make($password, $salt);

        $stmt->bind_param("sssssss", $pronouns, $givenname, $surname, $username, $email, $password_hash, $salt);
        $stmt->execute();

        return true;
    }

    public static function login($username, $password)
    {

        if (!isset($username, $password)) {
            return false;
        }

        $stmt = self::getDBConnection()->prepare("SELECT * FROM users WHERE username = ?");
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

    public function loadProfile()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $this->id = $user['user_id'];
            $this->givenname = $user['givenname'];
            $this->surname = $user['surname'];
            $this->pronouns = $user['pronouns'];
            $this->email = $user['email'];
            $this->role = $user['role'];
        }
    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'givenname' => $this->givenname,
            'surname' => $this->surname,
            'pronouns' => $this->pronouns,
            'email' => $this->email,
            'role' => $this->role,
            'telephone' => $this->telephone,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'city' => $this->city,
            'street' => $this->street,
            'house_number' => $this->house_number
        ];
    }

    public function save($givenname, $surname, $email)
    {
        $this->givenname = $givenname;
        $this->surname = $surname;
        $this->email = $email;

        $stmt = $this->dbconn->prepare("UPDATE users SET givenname = ?, surname = ?, email = ? WHERE username = ?");
        $stmt->bind_param("ssss",  $this->givenname, $this->surname, $this->email, $this->username);
        $stmt->execute();
    }

    public function save_admin($pronouns, $givenname, $surname, $email, $role)
    {
        $this->dbconn->begin_transaction();
        $this->setPronouns($pronouns);
        $this->setGivenname($givenname);
        $this->setSurname($surname);
        $this->setEmail($email);
        $this->setRole($role);

        $this->dbconn->commit();
        return true;
    }

    public function changePassword($password): void
    {
        $salt = Hash::salt(16);
        $password_hash = Hash::make($password, $salt);
        $stmt = $this->dbconn->prepare("UPDATE users SET password_hash = ?, salt = ? WHERE username = ?");
        $stmt->bind_param("sss", $password_hash, $salt, $this->username);
        $stmt->execute();
    }

    public static function getAllUsers()
    {
        $stmt = self::getDBConnection()->prepare("SELECT user_id, role, username, givenname, surname, email, pronouns FROM users");
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($user = $result->fetch_assoc()) {
            $users[] = $user;
        }

        $stmt->close();
        return $users;
    }

    public function delete()
    {
        $stmt = $this->dbconn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getGivenname(): string
    {
        $stmt = $this->dbconn->prepare("SELECT givenname FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['givenname'];
    }

    public function getSurname(): string
    {
        $stmt = $this->dbconn->prepare("SELECT surname FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['surname'];
    }

    public function getPronouns(): string
    {
        $stmt = $this->dbconn->prepare("SELECT pronouns FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['pronouns'];
    }

    public function getEmail(): string
    {
        $stmt = $this->dbconn->prepare("SELECT email FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['email'];
    }

    public function getTelephone(): string
    {
        $stmt = $this->dbconn->prepare("SELECT telephone FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['telephone'];
    }

    public function getCountry(): string
    {
        $stmt = $this->dbconn->prepare("SELECT country FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['country'];
    }

    public function getPostalCode(): string
    {
        $stmt = $this->dbconn->prepare("SELECT postal_code FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['postal_code'];
    }

    public function getCity(): string
    {
        $stmt = $this->dbconn->prepare("SELECT city FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['city'];
    }

    public function getStreet(): string
    {
        $stmt = $this->dbconn->prepare("SELECT street FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['street'];
    }

    public function getHouseNumber(): string
    {
        $stmt = $this->dbconn->prepare("SELECT house_number FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['house_number'];
    }

    public function getRole(): string
    {
        $stmt = $this->dbconn->prepare("SELECT role FROM users WHERE username = ?");
        $stmt->bind_param("s",  $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['role'];
    }

    public function setPronouns(string $pronouns): void
    {
        $this->pronouns = $pronouns;
        $stmt = $this->dbconn->prepare("UPDATE users SET pronouns = ? WHERE username = ?");
        $stmt->bind_param("ss",  $this->pronouns, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setGivenname(string $givenname): void
    {
        $this->givenname = $givenname;
        $stmt = $this->dbconn->prepare("UPDATE users SET givenname = ? WHERE username = ?");
        $stmt->bind_param("ss",  $this->givenname, $this->username);
        $stmt->execute();
        $stmt->close();
    }
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
        $stmt = $this->dbconn->prepare("UPDATE users SET surname = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->surname, $this->username);
        $stmt->execute();
        $stmt->close();
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
        $stmt = $this->dbconn->prepare("UPDATE users SET email = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->email, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
        $stmt = $this->dbconn->prepare("UPDATE users SET telephone = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->telephone, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
        $stmt = $this->dbconn->prepare("UPDATE users SET country = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->country, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setPostalCode(string $postal_code): void
    {
        $this->postal_code = $postal_code;
        $stmt = $this->dbconn->prepare("UPDATE users SET postal_code = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->postal_code, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
        $stmt = $this->dbconn->prepare("UPDATE users SET city = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->city, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
        $stmt = $this->dbconn->prepare("UPDATE users SET street = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->street, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setHouseNumber(string $house_number): void
    {
        $this->house_number = $house_number;
        $stmt = $this->dbconn->prepare("UPDATE users SET house_number = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->house_number, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
        $stmt = $this->dbconn->prepare("UPDATE users SET role = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->role, $this->username);
        $stmt->execute();
        $stmt->close();
    }
}
