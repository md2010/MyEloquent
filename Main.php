<?php

include 'Models/Auto.php';
include 'Models/Plane.php';

$auto = new Auto();
$values = ['audi', 'a5', 2018];
$auto->create($values);
$auto->save();


$values1 = ['audi', 'a1', 2016];
$auto1 = new Auto();
$auto1->create($values1); 
$auto1->save(); 

//test update
$auto->name = 'BMW';
$auto->save();

//$plane = new Plane();
//$valuesPlane = ['plane1', 54, 900];
//$plane->create($valuesPlane);

//$plane->name;
//$plane->name = 'planeNewName';

