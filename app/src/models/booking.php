<?php

namespace App\Models;

class Booking
{
    private $id;
    private $userId;
    private $roomId;
    private $startDate;
    private $endDate;
    private $status;

    public function __construct($id, $userId, $roomId, $startDate, $endDate, $status)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->roomId = $roomId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getRoomId()
    {
        return $this->roomId;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}