<?php

/**
 * Class AppData
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */
class AppData {
    /**
     * The version of the app data
     *
     * @var int
     */
    private $version;

    /**
     * The data assigned to the app data
     *
     * @var string
     */
    private $data;

    /**
     * AppData constructor.
     *
     * @param $version
     * @param $data
     */
    function __construct($version, $data) {
        $this->version      = (int)     $version;
        $this->data         = (string)  $data;
    }

    /**
     * Returns the scenes app data version
     *
     * @return int
     */
    function getVersion() {
        return $this->version;
    }

    /**
     * Returns the scenes app data data
     *
     * @return string
     */
    function getData() {
        return $this->data;
    }
}
?>