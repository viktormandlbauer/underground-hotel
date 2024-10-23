<?php

# Create a hashing class
class Hash {
    # Hash a string
    public static function make($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }

    # Generate a salt
    public static function salt($length) {
        return bin2hex(random_bytes($length));
    }

    # Generate a unique hash
    public static function unique() {
        return self::make(uniqid());
    }
}
?>