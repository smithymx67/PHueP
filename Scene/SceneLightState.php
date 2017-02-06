<?php

/**
 * Class SceneLightState
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
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
        // 1 to 254
        $conn = new ApiConnection();
        $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
        $data = '{"bri": ' . $bri .'}';
        $result = $conn->sendPutCmd($URL, $data);

        return $result;
    }

    /**
     * Sets the lights X value
     *
     * @param $x
     * @return array
     */
    function setLightX($x) {
        // Between 0 and 1
        $conn = new ApiConnection();
        $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
        $data = '{"xy": [' . $x .',' . $this->getLightXY()[1] . ']}';
        $result = $conn->sendPutCmd($URL, $data);

        return $result;
    }

    /**
     * Sets the lights Y value
     *
     * @param $y
     * @return array
     */
    function setLightY($y) {
        // Between 0 and 1
        $conn = new ApiConnection();
        $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
        $data = '{"xy": [' . $this->getLightXY()[0] .',' . $y . ']}';
        $result = $conn->sendPutCmd($URL, $data);

        return $result;
    }

    /**
     * Sets the lights CT value
     *
     * @param $ct
     * @return array
     */
    function setLightCT($ct) {
        // Between 153 an 500
        $conn = new ApiConnection();
        $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
        $data = '{"ct": ' . $ct .'}';
        $result = $conn->sendPutCmd($URL, $data);

        return $result;
    }

    /**
     * Set the lights on state
     *
     * @param $state
     * @return array
     */
    function setOn($state) {
        // true or false
        $conn = new ApiConnection();
        $URL = "scenes/{$this->sceneID}/lightstates/{$this->lightID}";
        $state = $state ? 'true' : 'false';
        $data = '{"on": ' . $state .'}';
        $result = $conn->sendPutCmd($URL, $data);

        return $result;
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