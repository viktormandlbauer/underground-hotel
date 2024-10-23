<?php

require 'src/config/Database.php';

class Room
{

    public static function getDBConnection()
    {
        return Database::getInstance()->getConnection();
    }

    public static function search_free_rooms($check_in_data, $check_out_date): array
    {
        $stmt = self::getDBConnection()->prepare("SELECT r.room_number FROM rooms r WHERE r.room_number NOT IN (
        SELECT r.room_number FROM rooms r INNER JOIN bookings b ON r.room_number = b.room_number
        WHERE (b.check_in_date BETWEEN ? AND ?) OR 
        (b.check_out_date  BETWEEN ? AND ?) OR 
        (b.check_in_date > ? AND b.check_out_date < ?));");
        $stmt->bind_param("ssssss", $check_in_data, $check_out_date, $check_in_data, $check_out_date, $check_in_data, $check_out_date);
        $stmt->execute();
        $result = $stmt->get_result();

        $rooms = [];
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
        return $rooms;
    }
}
