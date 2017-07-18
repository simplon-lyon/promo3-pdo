<?php

namespace entities;

/**
 * Description of SmallDoggo
 *
 * @author simplon
 */
class SmallDoggo {
    private $id;
    private $name;
    private $race;
    private $birthdate;
    private $isGood;
    
    function __construct(string $name, 
            string $race, 
            \DateTime $birthdate, 
            bool $isGood, 
            int $id = NULL) {
        $this->id = $id;
        $this->name = $name;
        $this->race = $race;
        $this->birthdate = $birthdate;
        $this->isGood = $isGood;
    }

}
