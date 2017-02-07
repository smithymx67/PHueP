<?php

/**
 * Class ScheduleCommand
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.1
 */
class ScheduleCommand {
    /**
     * The ID of the schedule linked to
     *
     * @var string
     */
    private $scheduleID;

    /**
     * The address to send the command
     *
     * @var string
     */
    private $commandAddress;

    /**
     * The method of the command
     *
     * @var string
     */
    private $commandMethod;

    /**
     * The payload of the command
     *
     * @var string
     */
    private $commandBody;

    /**
     * ScheduleCommand constructor.
     *
     * @param $scheduleID
     * @param $commandAddress
     * @param $commandMethod
     * @param $commandBody
     */
    function __construct($scheduleID, $commandAddress, $commandMethod, $commandBody) {
        $this->scheduleID           = (string) $scheduleID;
        $this->commandAddress       = (string) $commandAddress;
        $this->commandMethod        = (string) $commandMethod;
        $this->commandBody          = (string) $commandBody;
    }

    /**
     * Return the command address
     *
     * @return string
     */
    function getCommandAddress() {
        return $this->commandAddress;
    }

    /**
     * Return the request method
     *
     * @return string
     */
    function getCommandMethod() {
        return $this->commandMethod;
    }

    /**
     * Return the body of the command
     *
     * @return string
     */
    function getCommandBody() {
        return $this->commandBody;
    }

    /**
     * Set the commands address
     *
     * @param string $address
     * @return array
     */
    function setCommandAddress($address) {
        if(is_string($address)) {
            $conn = new ApiConnection();
            $URL = "schedules/" . $this->scheduleID;
            $data = '{"command": {
                    "address": "' . $address . '",
                    "method": "' . $this->commandMethod . '",
                    "body": ' . json_encode($this->commandBody) . '}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Set the commands request method
     *
     * @param string $method
     * @return array
     */
    function setCommandMethod($method) {
        if(is_string($method)) {
            $conn = new ApiConnection();
            $URL = "schedules/" . $this->scheduleID;
            $data = '{"command": {
                    "address": "' . $this->commandAddress . '",
                    "method": "' . $method . '",
                    "body": ' . json_encode($this->commandBody) . '}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Set the commands body
     *
     * @param array $cmd
     * @return array
     */
    function setCommandBody($cmd) {
        if(is_string($cmd)) {
            $conn = new ApiConnection();
            $URL = "schedules/" . $this->scheduleID;
            $data = '{"command": {
                    "address": "' . $this->commandAddress . '",
                    "method": "' . $this->commandMethod . '",
                    "body": ' . json_encode($cmd) . '}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }
}
?>