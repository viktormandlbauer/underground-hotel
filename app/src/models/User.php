<?php

require_once 'src/config/Database.php';
require_once 'src/util/Hash.php';

class User
{
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

    public function __construct($identifier)
    {
        if (is_int($identifier)) {
            $this->id = $identifier;
            $stmt = self::getDBConnection()->prepare("SELECT username FROM users WHERE user_id = ?");
            $stmt->bind_param("i", $this->id);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->username = $result->fetch_assoc()["username"] ?? null;

        } else if (is_string($identifier)) {
            $this->username = $identifier;
            $stmt = self::getDBConnection()->prepare("SELECT user_id FROM users WHERE username = ?");
            $stmt->bind_param("s", $this->username);
            $stmt->execute();
            $result = $stmt->get_result();
            $this->id = $result->fetch_assoc()["user_id"] ?? null;
        }
        if (!isset($this->givenname) && !isset($this->id)) {
            throw new Exception("User not found");
        }
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

    public function load()
    {
        $stmt = $this->getDBConnection()->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $this->username = $user['username'];
            $this->givenname = $user['givenname'];
            $this->surname = $user['surname'];
            $this->pronouns = $user['pronouns'];
            $this->email = $user['email'];
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

        $stmt = $this->getDBConnection()->prepare("UPDATE users SET givenname = ?, surname = ?, email = ? WHERE username = ?");
        $stmt->bind_param("ssss", $this->givenname, $this->surname, $this->email, $this->username);
        $stmt->execute();
    }


    public function changePassword($password): void
    {
        $salt = Hash::salt(16);
        $password_hash = Hash::make($password, $salt);
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET password_hash = ?, salt = ? WHERE username = ?");
        $stmt->bind_param("sss", $password_hash, $salt, $this->username);
        $stmt->execute();
    }

    public static function getAllUsers()
    {
        $stmt = self::getDBConnection()->prepare("SELECT user_id, username, role, givenname, surname, email, pronouns FROM users");
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($user = $result->fetch_assoc()) {
            $users[] = $user;
        }

        $stmt->close();
        return $users;
    }

    public static function getAllUsersSanitized()
    {
        $users = self::getAllUsers(); // Vorhandene Methode, die alle Benutzer abruft
        foreach ($users as &$user) {
            $user['user_id'] = intval($user['user_id']);
            $user['pronouns'] = htmlspecialchars($user['pronouns'], ENT_QUOTES, 'UTF-8');
            $user['username'] = htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8');
            $user['givenname'] = htmlspecialchars($user['givenname'], ENT_QUOTES, 'UTF-8');
            $user['surname'] = htmlspecialchars($user['surname'], ENT_QUOTES, 'UTF-8');
            $user['email'] = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');
            $user['role'] = htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8');
        }
        unset($user);
        return $users;
    }


    public static function getUseridByUsername($username)
    {
        $stmt = self::getDBConnection()->prepare("SELECT user_id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['user_id'] ?? null;

    }
    public function delete()
    {
        $stmt = $this->getDBConnection()->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
    }

    public function getGivenname(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT givenname FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['givenname'];
    }

    public function getSurname(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT surname FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['surname'];
    }

    public function getPronouns(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT pronouns FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['pronouns'];
    }

    public function getEmail(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT email FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['email'];
    }

    public function getTelephone(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT telephone FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['telephone'];
    }

    public function getCountry(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT country FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['country'];
    }

    public function getPostalCode(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT postal_code FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['postal_code'];
    }

    public function getCity(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT city FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['city'];
    }

    public function getStreet(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT street FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['street'];
    }

    public function getHouseNumber(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT house_number FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['house_number'];
    }

    public function getRole(): string
    {
        $stmt = $this->getDBConnection()->prepare("SELECT role FROM users WHERE username = ?");
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['role'];
    }

    public function setPronouns(string $pronouns): void
    {
        $this->pronouns = $pronouns;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET pronouns = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->pronouns, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setGivenname(string $givenname): void
    {
        $this->givenname = $givenname;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET givenname = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->givenname, $this->username);
        $stmt->execute();
        $stmt->close();
    }
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET surname = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->surname, $this->username);
        $stmt->execute();
        $stmt->close();
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET email = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->email, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET telephone = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->telephone, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET country = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->country, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setPostalCode(string $postal_code): void
    {
        $this->postal_code = $postal_code;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET postal_code = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->postal_code, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET city = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->city, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET street = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->street, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setHouseNumber(string $house_number): void
    {
        $this->house_number = $house_number;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET house_number = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->house_number, $this->username);
        $stmt->execute();
        $stmt->close();
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
        $stmt = $this->getDBConnection()->prepare("UPDATE users SET role = ? WHERE username = ?");
        $stmt->bind_param("ss", $this->role, $this->username);
        $stmt->execute();
        $stmt->close();
    }
}
