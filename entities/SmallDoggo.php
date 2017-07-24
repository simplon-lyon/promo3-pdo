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
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getRace() {
        return $this->race;
    }

    function getBirthdate() {
        return $this->birthdate;
    }

    function getIsGood() {
        return $this->isGood;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setRace($race) {
        $this->race = $race;
    }

    function setBirthdate($birthdate) {
        $this->birthdate = $birthdate;
    }

    function setIsGood($isGood) {
        $this->isGood = $isGood;
    }



}
