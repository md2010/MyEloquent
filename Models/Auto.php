<?php

include_once 'BaseModel.php';

class Auto extends BaseModel 
{
    public $attributes = ['name', 'model', 'year'];

    public function __construct()
    {
        parent::__construct($this->attributes);
    }

    public function setTable()
    {
        $this->table = get_class($this);
    }

}
