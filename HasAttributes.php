<?php

trait HasAttributes
{
    protected $attributes = [];

    public function getAttributes()
    {
        return $attributes;
    }

    public function setAttributes($key, $value)
    {
        if (! is_null($value) && array_key_exists($key, $this->attributes)) {
            $this->attributes[$key] = $value;
            return $this;
        }
    } 
  
    public function checkAttribute($key)
    {
        if (! $key) {
            return false;
        }
        if (array_key_exists($key, $this->attributes)) {
            return true;
        }
        else 
        {
            echo 'Invalid attribute';
            echo "<br>";
        }
    }

    

}

?>

    