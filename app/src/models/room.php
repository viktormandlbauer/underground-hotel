<?php

namespace App\Models;

class Room
{
    private $id;
    private $number;
    private $type;
    private $price;
    private $status;

    public function __construct($id, $number, $type, $price, $status)
    {
        $this->id = $id;
        $this->number = $number;
        $this->type = $type;
        $this->price = $price;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}