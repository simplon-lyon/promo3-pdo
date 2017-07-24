<?php

function myLoader($className) {
    $class = str_replace('\\', '/', $className);
    require($class . '.php');
}

spl_autoload_register('myLoader');

use entities\SmallDoggo;


$chien = new SmallDoggo('test', 'test', new DateTime(), true);
$doge = $chien;
modifier($chien);
$doge->setRace('autre race');
var_dump($chien);


function modifier(SmallDoggo $doge) {
    $doge->setName('doudidou');
    $doge->setBirthdate(new DateTime('2015-10-03'));
}

function dogeFactory($name,$race,$birthdate,$isGood) {
    $chien = new SmallDoggo($name, $race, $birthdate, $isGood);
    return $chien;
}