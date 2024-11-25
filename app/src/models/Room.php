<?php

require 'src/config/Database.php';

class Room
{

    public static function getDBConnection()
    {
        return Database::getInstance()->getConnection();
    }

    public static function search_free_rooms($check_in_data, $check_out_date, $price_min, $price_max): array
    {

        $stmt = self::getDBConnection()->prepare("SELECT r.room_number, r.type, r.description, r.image_path, r.price_per_night FROM rooms r 
        WHERE r.room_number NOT IN (
        SELECT r.room_number FROM rooms r INNER JOIN bookings b ON r.room_number = b.room_number
        WHERE (b.check_in_date BETWEEN ? AND ?) OR 
        (b.check_out_date  BETWEEN ? AND ?) OR 
        (b.check_in_date > ? AND b.check_out_date < ?)) AND r.price_per_night >= ? AND r.price_per_night <= ?;");
        $stmt->bind_param("ssssssdd", $check_in_data, $check_out_date, $check_in_data, $check_out_date, $check_in_data, $check_out_date, $price_min, $price_max);
        $stmt->execute();
        $result = $stmt->get_result();

        $rooms = [];
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }

        return $rooms;
    }

    public static function get_all_rooms(): array
    {
        $stmt = self::getDBConnection()->prepare("SELECT * FROM rooms");
        $stmt->execute();
        $result = $stmt->get_result();

        $rooms = [];
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }

        return $rooms;
    }
}
