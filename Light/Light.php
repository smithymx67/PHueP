<?php

/**
 * Class Light
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.2
 */
class Light {
    /**
     * The ID of the light in the bridge
     *
     * @var string
     */
    private $lightID;

    /**
     * The current state of the light
     *
     * @var LightState
     */
    private $lightState;

    /**
     * The type of light
     *
     * @var string
     */
    private $lightType;

    /**
     * The name of the light
     *
     * @var string
     */
    private $lightName;

    /**
     * The model number of the light
     *
     * @var string
     */
    private $modelNo;

    /**
     * The software version of the light
     *
     * @var string
     */
    private $softwareVersion;

    /**
     * The lights manufacture
     *
     * @var string
     */
    private $vendor;

    /**
     * The lights unique ID, normally the MAC address
     *
     * @var string
     */
    private $uuid;

    /**
     * Light constructor.
     *
     * @param $lightID
     * @param $lightType
     * @param $lightName
     * @param $modelNo
     * @param $softwareVersion
     * @param $vendor
     * @param $uuid
     * @param $lightState
     */
    function __construct($lightID, $lightType, $lightName, $modelNo, $softwareVersion, $vendor, $uuid, $lightState) {
        $this->lightID              = (int)     $lightID;
        $this->lightType            = (string)  $lightType;
        $this->lightName            = (string)  $lightName;
        $this->modelNo              = (string)  $modelNo;
        $this->softwareVersion      = (string)  $softwareVersion;
        $this->vendor               = (string)  $vendor;
        $this->uuid                 = (string)  $uuid;
        $this->lightState           = $lightState;
    }

    /**
     * Return the lights ID
     *
     * @return string
     */
    function getLightID() {
        return $this->lightID;
    }

    /**
     * Return the lights light state object
     *
     * @return LightState
     */
    function getLightState() {
        return $this->lightState;
    }

    /**
     * Return the lights type
     *
     * @return string
     */
    function getLightType() {
        return $this->lightType;
    }

    /**
     * Return the lights name
     *
     * @return string
     */
    function getLightName() {
        return $this->lightName;
    }

    /**
     * Return the lights model number
     *
     * @return string
     */
    function getModelNo() {
        return $this->modelNo;
    }

    /**
     * Return the lights software version
     *
     * @return string
     */
    function getSoftwareVersion() {
        return $this->softwareVersion;
    }

    /**
     * Return the lights vendor name
     *
     * @return string
     */
    function getVendor() {
        return $this->vendor;
    }

    /**
     * Return the lights UUID
     *
     * @return string
     */
    function getUUID() {
        return $this->uuid;
    }

    /**
     * Set the name of the light
     *
     * @param string $newName
     * @return array
     */
    function setLightName($newName) {
        if(is_string($newName) && strlen($newName) > 0 && strlen($newName) <= 32) {
            $conn = new ApiConnection();
            $URL = "lights/" . $this->lightID;
            $data = '{"name": "' . $newName .'"}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    function getLightDataJSON() {
        $data = array();
        $data["id"] = $this->lightID;
        $data["name"] = $this->lightName;
        $data["type"] = $this->lightType;
        $data["model"] = $this->modelNo;
        $data["softwareVer"] = $this->softwareVersion;
        $data["vendor"] = $this->vendor;
        $data["uuid"] = $this->uuid;

        $data["lightstate"]["on"] = $this->lightState->isOn();
        $data["lightstate"]["brightness"] = $this->lightState->getBrightness();
        $data["lightstate"]["saturation"] = $this->lightState->getSaturation();
        $data["lightstate"]["hue"] = $this->lightState->getHue();
        $data["lightstate"]["xy"] = $this->lightState->getXY();
        $data["lightstate"]["ct"] = $this->lightState->getCT();
        $data["lightstate"]["alert"] = $this->lightState->getAlert();
        $data["lightstate"]["effect"] = $this->lightState->getEffect();
        $data["lightstate"]["colormode"] = $this->lightState->getColorMode();

        return json_encode($data);
    }
}
?>