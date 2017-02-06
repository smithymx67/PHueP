<?php

/**
 * Class GroupState
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */
class GroupState {
    /**
     * Are any lights on
     *
     * @var bool
     */
    private $anyOn;

    /**
     * Are all lights on
     *
     * @var bool
     */
    private $allOn;

    /**
     * GroupState constructor.
     *
     * @param bool $anyOn
     * @param bool $allOn
     */
    function __construct($anyOn, $allOn) {
        $this->anyOn = (bool) $anyOn;
        $this->allOn = (bool) $allOn;
    }

    /**
     * Returns true if any of the lights in the group are on
     *
     * @return bool
     */
    function isAnyOn() {
        return $this->anyOn;
    }

    /**
     * Returns true if all the lights in the group are on
     *
     * @return bool
     */
    function isAllOn() {
        return $this->allOn;
    }
}
?>