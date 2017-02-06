<?php

/**
 * Class Bridge
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */

class Bridge {
    /**
     * The name of the bridge
     *
     * @var string
     */
    private $bridgeName;

    /**
     * The API version
     *
     * @var string
     */
    private $bridgeApiVersion;

    /**
     * The current software version
     *
     * @var string
     */
    private $bridgeSoftwareVersion;

    /**
     * The IP address of the bridge
     *
     * @var string
     */
    private $bridgeIpAddress;

    /**
     * The MAC address of the bridge
     *
     * @var string
     */
    private $bridgeMacAddress;

    /**
     * The netmask address of the bridge
     *
     * @var string
     */
    private $bridgeNetmask;

    /**
     * The gateway address of the bridge
     *
     * @var string
     */
    private $bridgeGateway;

    /**
     * Is DHCP enabled
     *
     * @var bool
     */
    private $bridgeDhcp;

    /**
     * The model of the bridge
     *
     * @var string
     */
    private $bridgeModel;

    /**
     * Bridge constructor.
     */
    function __construct() {
        $bridgeInfo = $this->requestBridgeInfo();
        $this->bridgeName               = (string)  $bridgeInfo["name"];
        $this->bridgeApiVersion         = (string)  $bridgeInfo["apiversion"];
        $this->bridgeSoftwareVersion    = (string)  $bridgeInfo["swversion"];
        $this->bridgeIpAddress          = (string)  $bridgeInfo["ipaddress"];
        $this->bridgeMacAddress         = (string)  $bridgeInfo["mac"];
        $this->bridgeNetmask            = (string)  $bridgeInfo["netmask"];
        $this->bridgeGateway            = (string)  $bridgeInfo["gateway"];
        $this->bridgeDhcp               = (bool)    $bridgeInfo["dhcp"];
        $this->bridgeModel              = (string)  $bridgeInfo["modelid"];
    }

    /**
     * Return the name of the bridge
     *
     * @return string
     */
    function getBridgeName() {
        return $this->bridgeName;
    }

    /**
     * Return the API version of the bridge
     *
     * @return string
     */
    function getBridgeApiVersion() {
        return $this->bridgeApiVersion;
    }

    /**
     * Return the software version of the bridge
     *
     * @return string
     */
    function getBridgeSoftwareVersion() {
        return $this->bridgeSoftwareVersion;
    }

    /**
     * Return the IP address of the bridge
     *
     * @return string
     */
    function getBridgeIpAddress() {
        return $this->bridgeIpAddress;
    }

    /**
     * Return the mac address of the bridge
     *
     * @return string
     */
    function getBridgeMacAddress() {
        return $this->bridgeMacAddress;
    }

    /**
     * Return the netmask of the bridge
     *
     * @return string
     */
    function getBridgeNetmask() {
        return $this->bridgeNetmask;
    }

    /**
     * Return the gateway of the bridge
     *
     * @return string
     */
    function getBridgeGateway() {
        return $this->bridgeGateway;
    }

    /**
     * Return true if the bridge has DHCP enabled
     *
     * @return bool
     */
    function getBridgeDhcp() {
        return $this->bridgeDhcp;
    }

    /**
     * Return the bridges model number
     *
     * @return string
     */
    function getBridgeModel() {
        return $this->bridgeModel;
    }

    /**
     * Return information about the bridge
     *
     * @return array
     */
    private function requestBridgeInfo() {
        $conn = new ApiConnection;
        $result = $conn->sendGetCmd("config");
        return $result;
    }
}
?>