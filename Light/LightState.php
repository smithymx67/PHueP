<?php

/**
 * Class LightState
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */
class LightState {
    /**
     * The ID of the light associated to this state
     *
     * @var string
     */
    private $lightID;

    /**
     * The state of the light, on or off
     *
     * @var bool
     */
    private $onState;

    /**
     * The brightness of the light
     *
     * @var int
     */
    private $brightness;

    /**
     * The hue of the light
     *
     * @var int
     */
    private $hue;

    /**
     * The saturation of the light
     *
     * @var int
     */
    private $saturation;

    /**
     * The XY values for the light
     *
     * @var array
     */
    private $xy;

    /**
     * The CT value for the light
     *
     * @var int
     */
    private $ct;

    /**
     * The current alert mode of the light
     *
     * @var string
     */
    private $alert;

    /**
     * The current effect of the light
     *
     * @var string
     */
    private $effect;

    /**
     * The current color mode the light is using
     *
     * @var string
     */
    private $colormode;

    /**
     * Is the light reachable by the bridge
     *
     * @var bool
     */
    private $reachable;

    /**
     * LightState constructor.
     *
     * @param $lightID
     * @param $onState
     * @param $brightness
     * @param $hue
     * @param $saturation
     * @param $xy
     * @param $ct
     * @param $alert
     * @param $effect
     * @param $colormode
     * @param $reachable
     */
    function __construct($lightID, $onState, $brightness, $hue, $saturation, $xy, $ct, $alert, $effect, $colormode, $reachable) {
        $this->lightID      = (string) $lightID;
        $this->onState      = (bool)   $onState;
        $this->brightness   = (int)    $brightness;
        $this->hue          = (int)    $hue;
        $this->saturation   = (int)    $saturation;
        $this->xy           = (array)  $xy;
        $this->ct           = (int)    $ct;
        $this->alert        = (string) $alert;
        $this->effect       = (string) $effect;
        $this->colormode    = (string) $colormode;
        $this->reachable    = (bool)   $reachable;
    }

    /**
     * Return the lights brightness value
     *
     * @return int
     */
    function getBrightness() {
        return $this->brightness;
    }

    /**
     * Return the lights hue value
     *
     * @return int
     */
    function getHue() {
        return $this->hue;
    }

    /**
     * Return the lights saturation value
     *
     * @return int
     */
    function getSaturation() {
        return $this->saturation;
    }

    /**
     * Return the lights XY values
     *
     * @return array
     */
    function getXY() {
        return $this->xy;
    }

    /**
     * Return the lights CT value
     *
     * @return int
     */
    function getCT() {
        return $this->ct;
    }

    /**
     * Return the lights alert state
     *
     * @return string
     */
    function getAlert() {
        return $this->alert;
    }

    /**
     * Return the lights current effect
     *
     * @return string
     */
    function getEffect() {
        return $this->effect;
    }

    /**
     * Return the lights color mode
     *
     * @return string
     */
    function getColorMode() {
        return $this->colormode;
    }

    /**
     * Set the lights on state
     *
     * @param bool $state
     * @return array
     */
    function setOnState($state) {
        // true or false
        $conn = new ApiConnection();
        $lightURL = "lights/" . $this->lightID . "/state";
        $state = $state ? 'true' : 'false';
        $data = '{"on": ' . $state .'}';
        $result = $conn->sendPutCmd($lightURL, $data);

        return $result;
    }

    /**
     * Set the lights brightness value
     *
     * @param int $bri
     * @return array
     */
    function setBrightness($bri) {
        // 1 to 254
        $conn = new ApiConnection();
        $lightURL = "lights/" . $this->lightID . "/state";
        $data = '{"bri": ' . $bri .'}';
        $result = $conn->sendPutCmd($lightURL, $data);

        return $result;
    }

    /**
     * Set the lights hue value
     *
     * @param int $hue
     * @return array
     */
    function setHue($hue) {
        // 0 to 65535
        $conn = new ApiConnection();
        $lightURL = "lights/" . $this->lightID . "/state";
        $data = '{"hue": ' . $hue .'}';
        $result = $conn->sendPutCmd($lightURL, $data);

        return $result;
    }

    /**
     * Set the lights saturation value
     *
     * @param int $sat
     * @return array
     */
    function setSaturation($sat) {
        // 0 to 254
        $conn = new ApiConnection();
        $lightURL = "lights/" . $this->lightID . "/state";
        $data = '{"sat": ' . $sat .'}';
        $result = $conn->sendPutCmd($lightURL, $data);

        return $result;
    }

    /**
     * Set the lights X value
     *
     * @param double $x
     * @return array
     */
    function setX($x) {
        // Between 0 and 1
        $conn = new ApiConnection();
        $lightURL = "lights/" . $this->lightID . "/state";
        $data = '{"xy": [' . $x .',' . $this->getXY()[1] . ']}';
        $result = $conn->sendPutCmd($lightURL, $data);

        return $result;
    }

    /**
     * Set the lights Y value
     *
     * @param double $y
     * @return array
     */
    function setY($y) {
        // Between 0 and 1
        $conn = new ApiConnection();
        $lightURL = "lights/" . $this->lightID . "/state";
        $data = '{"xy": [' . $this->getXY()[0] .',' . $y . ']}';
        $result = $conn->sendPutCmd($lightURL, $data);

        return $result;
    }

    /**
     * Set the lights CT value
     *
     * @param int $ct
     * @return array
     */
    function setCt($ct){
        // Between 153 an 500
        $conn = new ApiConnection();
        $lightURL = "lights/" . $this->lightID . "/state";
        $data = '{"ct": ' . $ct .'}';
        $result = $conn->sendPutCmd($lightURL, $data);

        return $result;
    }

    /**
     * Set the lights alert state
     *
     * @param string $alert
     * @return array
     */
    function setAlert($alert) {
        // none, select, lselect
        $conn = new ApiConnection();
        $lightURL = "lights/" . $this->lightID . "/state";
        $data = '{"alert": "' . $alert .'"}';
        $result = $conn->sendPutCmd($lightURL, $data);

        return $result;
    }

    /**
     * Set the lights effect state
     *
     * @param string $effect
     * @return array
     */
    function setEffect($effect) {
        // none or colorloop
        $conn = new ApiConnection();
        $lightURL = "lights/" . $this->lightID . "/state";
        $data = '{"effect": "' . $effect .'"}';
        $result = $conn->sendPutCmd($lightURL, $data);

        return $result;
    }

    /**
     * Returns true if the light is on
     *
     * @return bool
     */
    function isOn() {
        return $this->onState;
    }

    /**
     * Returns true if the light is reachable
     *
     * @return bool
     */
    function isReachable() {
        return $this->reachable;
    }
}
?>