<?php

/**
 * Class GroupClass
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */
class GroupClass {
    /**
     * Array of valid room classes
     *
     * @var array
     */
    private $validClasses = array(
        "LIVING_ROOM" => "Living room",
        "KITCHEN" => "Kitchen",
        "DINING" => "Dining",
        "BEDROOM" => "Bedroom",
        "KIDS_BEDROOM" => "Kids bedroom",
        "BATHROOM" => "Bathroom",
        "NURSERY" => "NURSERY",
        "RECREATION" => "Recreation",
        "OFFICE" => "Office",
        "GYM" => "Gym",
        "HALLWAY" => "Hallway",
        "TOILET" => "Toilet",
        "FRONT_DOOR" => "Front door",
        "GARAGE" => "Garage",
        "TERRACE" => "Terrace",
        "GARDEN" => "Garden",
        "DRIVEWAY" => "Driveway",
        "CARPORT" => "Carport",
        "OTHER" => "Other"
    );

    /**
     * Returns the list of valid classes
     *
     * @return array
     */
    function getValidClasses() {
        return $this->validClasses;
    }

    /**
     * Check to see if the given class is valid
     *
     * @param $class
     * @return string
     */
    function isClassValid($class) {
        if(in_array($class, $this->validClasses)) {
            return $class;
        } else {
            return "Other";
        }
    }
}
?>