<?php

include 'Models/Auto.php';
include 'Models/Plane.php';

$auto = new Auto();
//$values = ['audi', 'a5', 2018];
//$auto->create($values);
/*
$values1 = ['audi', 'a1', 2016];
$auto1 = new Auto();
$auto1->create($values1); */

echo $auto->name;
$auto->year = 2017;

//$plane = new Plane();
//$valuesPlane = ['plane1', 54, 900];
//$plane->create($valuesPlane);

//$plane->__get('name');
//$plane->name = 'planeNewName';

