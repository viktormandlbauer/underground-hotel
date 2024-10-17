<?php

namespace App\Models;

include 'src/config/dbaccess.php';

class Room
{
    private $id;
    private $room_type;
    private $description;
    private $price_per_night;
    private $image_path;

    public function __construct($id, $room_type, $description, $price_per_night, $image_path)
    {
        $this->id = $id;
        $this->room_type = $room_type;
        $this->description = $description;
        $this->price_per_night = $price_per_night;
        $this->image_path = $image_path;
    }

    public function load(){
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = ?");
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $room = $result->fetch_assoc();
        $this->room_type = $room['room_type'];
        $this->description = $room['description'];
        $this->price_per_night = $room['price_per_night'];
        $this->image_path = $room['image_path'];
    }

    public static function search_free_rooms($check_in_data, $check_out_date): array
    {
        global $conn;
        $stmt = $conn->prepare("SELECT room_id FROM rooms r WHERE r.room_id NOT IN (
        SELECT r.room_id FROM rooms r INNER JOIN bookings b ON r.room_id = b.room_id
        WHERE (b.check_in_date BETWEEN ? AND ?) OR 
        (b.check_out_date  BETWEEN ? AND ?) OR 
        (b.check_in_date > ? AND b.check_out_date < ?));");
        $stmt->bind_param("ssssss", $check_in_data, $check_out_date, $check_in_data, $check_out_date, $check_in_data, $check_out_date);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}