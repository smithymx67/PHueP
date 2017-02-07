<?php

/**
 * Class SceneLightState
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.1
 */
class SceneLightState {
    /**
     * The ID of the scene this is linked to
     *
     * @var string
     */
    private $sceneID;

    /**
     * The ID of the light
     *
     * @var string
     */
    private $lightID;

    /**
     * Is the light on or off
     *
     * @var bool
     */
    private $lightOn;

    /**
     * The lights brightness
     *
     * @var int
     */
    private $lightBrightness;

    /**
     * The XY values for the light
     *
     * @var array
     */
    private $lightXY;

    /**
     * The CT value for the light
     *
     * @var int
     */
    private $lightCT;

    /**
     * SceneLightState constructor.
     *
     * @param $sceneID
     * @param $lightID
     * @param $lightOn
     * @param $lightBrightness
     * @param $lightXY
     * @param $lightCT
     */
    function __construct($sceneID, $lightID, $lightOn, $lightBrightness, $lightXY, $lightCT) {
        $this->sceneID              = (string) $sceneID;
        $this->lightID              = (string) $lightID;
        $this->lightOn              = (bool)   $lightOn;
        $this->lightBrightness      = (int)    $lightBrightness;
        $this->lightXY              = (array)  $lightXY;
        $this->lightCT              = (int)    $lightCT;
    }

    /**
     * Returns the ID of the light the state is linked to
     *
     * @return string
     */
    function getLightID() {
        return $this->lightID;
    }

    /**
     * Returns the brightness of the light
     *
     * @return int
     */
    function getLightBrightness() {
        return $this->lightBrightness;
    }

    /**
     * Returns the XY values of the light
     *
     * @return array
     */
    function getLightXY() {
        return $this->lightXY;
    }

    /**
     * Returns the CT values of the light
     *
     * @return int
     */
    function getLightCT() {
        return $this->lightCT;
    }

    /**
     * Sets the brightness of the light
     *
     * @param $bri
     * @return array
     */
    function setLightBrightness($bri) {
        if(is_int($bri) && $bri >= 1 && $bri <= 254) {
            $conn = new ApiConnection();
            $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
            $data = '{"bri": ' . $bri .'}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Sets the lights X value
     *
     * @param $x
     * @return array
     */
    function setLightX($x) {
        if(is_double($x) && $x >= 0 && $x <= 1) {
            $conn = new ApiConnection();
            $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
            $data = '{"xy": [' . $x .',' . $this->getLightXY()[1] . ']}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Sets the lights Y value
     *
     * @param $y
     * @return array
     */
    function setLightY($y) {
        if(is_double($y) && $y >= 0 && $y <= 1) {
            $conn = new ApiConnection();
            $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
            $data = '{"xy": [' . $this->getLightXY()[0] .',' . $y . ']}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Sets the lights CT value
     *
     * @param $ct
     * @return array
     */
    function setLightCT($ct) {
        if(is_int($ct) && $ct >= 153 && $ct <= 500) {
            $conn = new ApiConnection();
            $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
            $data = '{"ct": ' . $ct .'}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Set the lights on state
     *
     * @param $state
     * @return array
     */
    function setOn($state) {
        if(is_bool($state)) {
            $conn = new ApiConnection();
            $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
            $state = $state ? 'true' : 'false';
            $data = '{"on": ' . $state .'}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Returns true if the light is on
     *
     * @return bool
     */
    function isOn() {
        return $this->lightOn;
    }
}
?>