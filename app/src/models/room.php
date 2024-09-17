<?php

namespace App\Models;

include 'src/config/dbaccess.php';

class Room
{
    public static function search_free_rooms($check_in_data, $check_out_date): array
    {
        global $conn;
        $stmt = $conn->prepare("SELECT room_number FROM rooms r WHERE r.room_number NOT IN (
        SELECT room_number FROM rooms r INNER JOIN bookings b ON r.room_id = b.room_id
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
