<?php

require_once 'src/config/Database.php';

class Room
{

    public $number;
    public $name;
    public $description;
    public $type;
    public $price_per_night;
    public $image_path;

    public static function getDBConnection()
    {
        return Database::getInstance()->getConnection();
    }

    public function __construct($number, $name, $description, $type, $price_per_night, $image_path)
    {
        $this->number = intval($number);
        $this->name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $this->description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        $this->type = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');
        $this->price_per_night = floatval($price_per_night);
        $this->image_path = $image_path ?? null;
    }

    public static function createRoom($number, $name, $description, $type, $price_per_night, $image_path)
    {
        $room = new Room($number, $name, $description, $type, $price_per_night, $image_path);

        $stmt = self::getDBConnection()->prepare('INSERT INTO rooms (number, name, description, type, price_per_night, image_path ) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('isssds', $room->number, $room->name, $room->description, $room->type, $room->price_per_night, $image_path);
        $stmt->execute();

        return $room;
    }

    public static function updateRoom($number, $name, $description, $type, $price_per_night, $image_path)
    {
        $stmt = self::getDBConnection()->prepare('UPDATE rooms SET number = ?, name = ?, description = ?, type = ?, price_per_night = ?, image_path = ? WHERE number = ?');
        $stmt->bind_param('isssdsi', $number, $name, $description, $type, $price_per_night, $image_path, $number);
        $stmt->execute();
    }

    public static function deleteRoom($number)
    {
        $stmt = self::getDBConnection()->prepare("DELETE FROM rooms WHERE number = ?");
        $stmt->bind_param("i", $number);
        $stmt->execute();
    }

    public static function searchFreeRooms($check_in_data, $check_out_date, $price_min, $price_max): array
    {

        $stmt = self::getDBConnection()->prepare("SELECT r.number, r.name, r.type, r.description, r.image_path, r.price_per_night FROM rooms r 
        WHERE r.number NOT IN (
        SELECT r.number FROM rooms r INNER JOIN bookings b ON r.number = b.room_number
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

    public static function getAllRooms(): array
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

    public static function bookRoom($bookingData)
    {

        $stmt = self::getDBConnection()->prepare("INSERT INTO bookings (user_id, room_number, check_in_date, check_out_date, price_per_night, status, breakfast, parking, pet, additional_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissdsssss", $bookingData['user_id'], $bookingData['room_number'], $bookingData['start_date'], $bookingData['end_date'],$bookingData['price_per_night'], $bookingData['status'], $bookingData['breakfast'], $bookingData['parking'], $bookingData['pet'], $bookingData['additional_info']);
        $stmt->execute();

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
