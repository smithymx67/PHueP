<?php

/**
 * Class GroupAction
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */
class GroupAction {
    /**
     * The ID of the group that this state is linked too
     *
     * @var string
     */
    private $groupID;

    /**
     * Are the groups lights on
     *
     * @var bool
     */
    private $groupOn;

    /**
     * The groups brightness
     *
     * @var int
     */
    private $groupBrightness;

    /**
     * The groups hue
     *
     * @var int
     */
    private $groupHue;

    /**
     * The groups saturation
     *
     * @var int
     */
    private $groupSaturation;

    /**
     * The groups effect
     *
     * @var string
     */
    private $groupEffect;

    /**
     * The groups X and Y values
     *
     * @var array
     */
    private $groupXY;

    /**
     * The groups CT value
     *
     * @var int
     */
    private $groupCT;

    /**
     * The groups alert mode
     *
     * @var string
     */
    private $groupAlert;

    /**
     * The groups color mode
     *
     * @var string
     */
    private $groupColorMode;

    /**
     * GroupAction constructor.
     *
     * @param $groupID
     * @param $groupOn
     * @param $groupBrightness
     * @param $groupHue
     * @param $groupSaturation
     * @param $groupEffect
     * @param $groupXY
     * @param $groupCT
     * @param $groupAlert
     * @param $groupColorMode
     */
    function __construct($groupID, $groupOn, $groupBrightness, $groupHue, $groupSaturation,
                         $groupEffect, $groupXY, $groupCT, $groupAlert, $groupColorMode) {
        $this->groupID              = (string)  $groupID;
        $this->groupOn              = (bool)    $groupOn;
        $this->groupBrightness      = (int)     $groupBrightness;
        $this->groupHue             = (int)     $groupHue;
        $this->groupSaturation      = (int)     $groupSaturation;
        $this->groupEffect          = (string)  $groupEffect;
        $this->groupXY              = (array)   $groupXY;
        $this->groupCT              = (int)     $groupCT;
        $this->groupAlert           = (string)  $groupAlert;
        $this->groupColorMode       = (string)  $groupColorMode;
    }


    /**
     * Return the groups brightness value
     *
     * @return int
     */
    function getGroupBrightness() {
        return $this->groupBrightness;
    }

    /**
     * Return the groups hue value
     *
     * @return int
     */
    function getGroupHue() {
        return $this->groupHue;
    }

    /**
     * Return the groups saturation value
     *
     * @return int
     */
    function getGroupSaturation() {
        return $this->groupSaturation;
    }

    /**
     * Return the groups effect state
     *
     * @return string
     */
    function getGroupEffect() {
        return $this->groupEffect;
    }

    /**
     * Return the groups XY values
     *
     * @return array
     */
    function getGroupXY() {
        return $this->groupXY;
    }

    /**
     * Return the groups CT value
     *
     * @return int
     */
    function getGroupCT() {
        return $this->groupCT;
    }

    /**
     * Return the groups alert state
     *
     * @return string
     */
    function getGroupAlert() {
        return $this->groupAlert;
    }

    /**
     * Return the groups color mode
     *
     * @return string
     */
    function getGroupColorMode() {
        return $this->groupColorMode;
    }

    /**
     * Set the groups on state
     *
     * @param bool $state
     * @return array
     */
    function setGroupOn($state) {
        // true or false
        $conn = new ApiConnection();
        $url = "groups/" . $this->groupID . "/action";
        $state = $state ? 'true' : 'false';
        $data = '{"on": ' . $state .'}';
        $result = $conn->sendPutCmd($url, $data);

        return $result;
    }

    /**
     * Set the groups brightness state
     *
     * @param integer $bri
     * @return array
     */
    function setGroupBrightness($bri) {
        // 0 to 254
        $conn = new ApiConnection();
        $url = "groups/" . $this->groupID . "/action";
        $data = '{"bri": ' . $bri .'}';
        $result = $conn->sendPutCmd($url, $data);

        return $result;
    }

    /**
     * Set the groups hue state
     *
     * @param integer $hue
     * @return array
     */
    function setGroupHue($hue) {
        // 0 to 65535
        $conn = new ApiConnection();
        $url = "groups/" . $this->groupID . "/action";
        $data = '{"hue": ' . $hue .'}';
        $result = $conn->sendPutCmd($url, $data);

        return $result;
    }

    /**
     * Set the groups saturation state
     *
     * @param integer $sat
     * @return array
     */
    function setGroupSaturation($sat) {
        // 0 to 254
        $conn = new ApiConnection();
        $url = "groups/" . $this->groupID . "/action";
        $data = '{"sat": ' . $sat .'}';
        $result = $conn->sendPutCmd($url, $data);

        return $result;
    }

    /**
     * Set the groups effect state
     *
     * @param string $effect
     * @return array
     */
    function setGroupEffect($effect) {
        // none or colorloop
        $conn = new ApiConnection();
        $url = "groups/" . $this->groupID . "/action";
        $data = '{"effect": "' . $effect .'"}';
        $result = $conn->sendPutCmd($url, $data);

        return $result;
    }

    /**
     * Set the groups X state
     *
     * @param double $x
     * @return array
     */
    function setGroupX($x) {
        // Between 0 and 1
        $conn = new ApiConnection();
        $url = "groups/" . $this->groupID . "/action";
        $data = '{"xy": [' . $x .',' . $this->getGroupXY()[1] . ']}';
        $result = $conn->sendPutCmd($url, $data);

        return $result;
    }

    /**
     * Set the groups Y state
     *
     * @param double $y
     * @return array
     */
    function setGroupY($y) {
        // Between 0 and 1
        $conn = new ApiConnection();
        $url = "groups/" . $this->groupID . "/action";
        $data = '{"xy": [' . $this->getGroupXY()[0] .',' . $y . ']}';
        $result = $conn->sendPutCmd($url, $data);

        return $result;
    }

    /**
     * Set the groups CT state
     *
     * @param integer $ct
     * @return array
     */
    function setGroupCT($ct) {
        // Between 153 an 500
        $conn = new ApiConnection();
        $url = "groups/" . $this->groupID . "/action";
        $data = '{"ct": ' . $ct .'}';
        $result = $conn->sendPutCmd($url, $data);

        return $result;
    }

    /**
     * Set the groups alert state
     *
     * @param string $alert
     * @return array
     */
    function setGroupAlert($alert) {
        // none, select, lselect
        $conn = new ApiConnection();
        $url = "groups/" . $this->groupID . "/action";
        $data = '{"alert": "' . $alert .'"}';
        $result = $conn->sendPutCmd($url, $data);

        return $result;
    }

    /**
     * Return true of the group is on
     *
     * @return bool
     */
    function isGroupOn() {
        return $this->groupOn;
    }
}
?>