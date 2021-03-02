<?php

include_once 'BaseModel.php';

class Plane extends BaseModel 
{
    public $attributes = ['name', 'passengersCapacity', 'maxSpeed'];

    public function __construct()
    {
        parent::__construct($this->attributes);
    }

}