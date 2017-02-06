<?php

/**
 * Class HueError
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */
class HueError {
    /**
     * The error code
     *
     * @var int
     */
    private $errorType;

    /**
     * The address the error came from
     *
     * @var string
     */
    private $errorAddress;

    /**
     * A description of the error
     *
     * @var string
     */
    private $errorDescription;

    /**
     * HueError constructor.
     *
     * @param int $errorType
     * @param string $errorAddress
     * @param string $errorDescription
     */
    function __construct($errorType, $errorAddress, $errorDescription) {
        $this->errorType            = (int)    $errorType;
        $this->errorAddress         = (string) $errorAddress;
        $this->errorDescription     = (string) $errorDescription;
    }

    /**
     * Return the error type
     *
     * @return int
     */
    function getErrorType() {
        return $this->errorType;
    }

    /**
     * Return the error address
     *
     * @return string
     */
    function getErrorAddress() {
        return $this->errorAddress;
    }

    /**
     * Return the error description
     *
     * @return string
     */
    function getErrorDescription() {
        return $this->errorDescription;
    }
}
?>