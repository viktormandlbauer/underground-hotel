<?php

require_once 'src/config/Database.php';

class Booking
{
    private $id;

    public ?array $booking;
    public static function getDBConnection()
    {
        return Database::getInstance()->getConnection();
    }

    public function __construct($identifier)
    {
        $this->id = $identifier;
        $stmt = self::getDBConnection()->prepare("SELECT * FROM bookings WHERE booking_id = ?");
        $stmt->bind_param("i", $identifier);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->booking = $result->fetch_assoc();
    
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

    public static function createBooking($user_id, $room_number, $check_in_date, $check_out_date, $status, $breakfast, $parking, $pet, $additional_info, $price_per_night)
    {
        $price_per_night = Room::getRoomPrice($room_number);
        $stmt = self::getDBConnection()->prepare("INSERT INTO bookings (user_id, room_number, check_in_date, check_out_date, status, breakfast, parking, pet, additional_info, price_per_night) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssiiisd", $user_id, $room_number, $check_in_date, $check_out_date, $status, $breakfast, $parking, $pet, $additional_info, $price_per_night);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function setUserId($user_id)
    {
        $stmt = self::getDBConnection()->prepare("UPDATE bookings SET user_id = ? WHERE booking_id = ?");
        $stmt->bind_param("ii", $user_id, $this->id);
        $stmt->execute();
    }

    public function setRoomNumber($room_number)
    {
        $stmt = self::getDBConnection()->prepare("UPDATE bookings SET room_number = ? WHERE booking_id = ?");
        $stmt->bind_param("ii", $room_number, $this->id);
        $stmt->execute();
    }

    public function setCheckIn($start_date)
    {
        $stmt = self::getDBConnection()->prepare("UPDATE bookings SET check_in_date = ? WHERE booking_id = ?");
        $stmt->bind_param("si", $start_date, $this->id);
        $stmt->execute();
    }

    public function setCheckOut($end_date)
    {
        $stmt = self::getDBConnection()->prepare("UPDATE bookings SET check_out_date = ? WHERE booking_id = ?");
        $stmt->bind_param("si", $end_date, $this->id);
        $stmt->execute();
    }

    public function setStatus($status)
    {
        $stmt = self::getDBConnection()->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
        $stmt->bind_param("si", $status, $this->id);
        $stmt->execute();
    }

    public function setBreakfast($breakfast)
    {
        $stmt = self::getDBConnection()->prepare("UPDATE bookings SET breakfast = ? WHERE booking_id = ?");
        $stmt->bind_param("ii", $breakfast, $this->id);
        $stmt->execute();
    }

    public function setParking($parking)
    {
        $stmt = self::getDBConnection()->prepare("UPDATE bookings SET parking = ? WHERE booking_id = ?");
        $stmt->bind_param("ii", $parking, $this->id);
        $stmt->execute();
    }

    public function setPet($pet)
    {
        $stmt = self::getDBConnection()->prepare("UPDATE bookings SET pet = ? WHERE booking_id = ?");
        $stmt->bind_param("ii", $pet, $this->id);
        $stmt->execute();
    }

    public function setAdditionalInfo($additional_info)
    {
        $stmt = self::getDBConnection()->prepare("UPDATE bookings SET additional_info = ? WHERE booking_id = ?");
        $stmt->bind_param("si", $additional_info, $this->id);
        $stmt->execute();
    }
}
