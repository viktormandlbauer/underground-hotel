<?php

require_once 'src/config/Database.php';

class Booking
{
    public static function getDBConnection()
    {
        return Database::getInstance()->getConnection();
    }
    public static function getMyBookings($user_id)
    {
        $stmt = self::getDBConnection()->prepare("SELECT * FROM bookings WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $bookings = [];
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }

        return $bookings;
    }

    public static function getAllBookings()
    {
        $stmt = self::getDBConnection()->prepare("SELECT * FROM bookings");
        $stmt->execute();
        $result = $stmt->get_result();

        $bookings = [];
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }

        return $bookings;
    }
}
