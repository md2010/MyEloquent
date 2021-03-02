<?php

include 'Auto.php';

$auto = new Auto();
$values = ['audi', 'a5', 2018];
$auto->create($values);
/*
$values1 = ['audi', 'a1', 2016];
$auto1 = new Auto();
$auto1->create($values1); */

$auto->__get('mom');
$auto->__set('year', 2017);

?>