<?php

function myLoader($className) {
    $class = str_replace('\\', '/', $className);
    require($class . '.php');
}

spl_autoload_register('myLoader');

use data\DataDoggo;
use entities\SmallDoggo;

$data = new DataDoggo();

//echo '<pre>';
//var_dump($data->getAllDoggo());
//echo '</pre>';

//echo '<pre>';
//var_dump($data->getDoggoById(1000000000));
//echo '</pre>';

//$data->addDoggo(new SmallDoggo('test-data', 'test-data', new DateTime, true));
//$data->updateDoggo(new SmallDoggo('test-modif', 'test-modif', new DateTime, true, 1));
$data->deleteDoggo(new SmallDoggo('NULL', 'NULL', new DateTime(), false, 16));