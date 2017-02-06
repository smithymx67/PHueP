<?php

/**
 * Class Group
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */
class Group {
    /**
     * The ID of the group in the bridge
     *
     * @var string
     */
    private $groupID;

    /**
     * The name of the group
     *
     * @var string
     */
    private $groupName;

    /**
     * The lights in the group
     *
     * @var array
     */
    private $groupLights;

    /**
     * The type of group
     *
     * @var string
     */
    private $groupType;

    /**
     * The class of group
     *
     * @var string
     */
    private $groupClass;

    /**
     * The state of the group
     *
     * @var GroupState
     */
    private $groupState;

    /**
     * Actions of the group
     *
     * @var GroupAction
     */
    private $groupAction;

    /**
     * Group constructor.
     *
     * @param $groupID
     * @param $groupName
     * @param $groupType
     * @param $groupClass
     * @param $groupState
     * @param $groupAction
     * @param $groupLights
     */
    function __construct($groupID, $groupName, $groupType, $groupClass, $groupState, $groupAction, $groupLights) {
        $this->groupID          = (string) $groupID;
        $this->groupName        = (string) $groupName;
        $this->groupType        = (string) $groupType;
        $this->groupClass       = (string) $groupClass;
        $this->groupLights      = (array)  $groupLights;
        $this->groupState       = $groupState;
        $this->groupAction      = $groupAction;
    }

    /**
     * Returns the group ID
     *
     * @return string
     */
    function getGroupID() {
        return $this->groupID;
    }

    /**
     * Returns the group name
     *
     * @return string
     */
    function getGroupName() {
        return $this->groupName;
    }

    /**
     * Returns the lights in the group
     *
     * @return array
     */
    function getGroupLights() {
        return $this->groupLights;
    }

    /**
     * Returns the type of the group
     *
     * @return string
     */
    function getGroupType() {
        return $this->groupType;
    }

    /**
     * Returns the class of the group
     *
     * @return string
     */
    function getGroupClass() {
        return $this->groupClass;
    }

    /**
     * Returns the object with the state of the group
     *
     * @return GroupState
     */
    function getGroupState() {
        return $this->groupState;
    }

    /**
     * Returns the object to interact with the group
     *
     * @return GroupAction
     */
    function getGroupAction() {
        return $this->groupAction;
    }

    /**
     * Method to set the name of a group
     *
     * @param string $name  The name of the group
     * @return array
     */
    function setGroupName($name) {
        // 0 and 32 string
        $conn = new ApiConnection();
        $groupURL = "groups/" . $this->groupID;
        $data = '{"name": "' . $name .'"}';
        $result = $conn->sendPutCmd($groupURL, $data);

        return $result;
    }

    /**
     * Method to set the lights inside a group
     *
     * @param array $lights     List of all lights by ID in the group
     * @return array
     */
    function setGroupLights($lights) {
        // Light ids in string format
        $conn = new ApiConnection();
        $groupURL = "groups/" . $this->groupID;
        $data = '{"lights": ' . json_encode($lights) .'}';
        $result = $conn->sendPutCmd($groupURL, $data);

        return $result;
    }

    /**
     * Method to set a groups class
     *
     * @param string $class     The name of the room the lights are in
     * @return array
     */
    function setGroupClass($class) {
        // one of the pre defined names
        $conn = new ApiConnection();
        $groupURL = "groups/" . $this->groupID;
        $data = '{"class": "' . $class .'"}';
        $result = $conn->sendPutCmd($groupURL, $data);

        return $result;
    }

    /**
     * Method to delete a group
     *
     * @param string $id    The ID of a group
     * @return array
     */
    function deleteGroup($id) {
        $conn = new ApiConnection();
        $groupURL = "groups/{$id}";
        $result = $conn->sendDeleteCmd($groupURL);

        return $result;
    }

    /**
     * Recall the scene to this group
     *
     * @param string $sceneID
     * @return array
     */
    function recallScene($sceneID) {
        $conn = new ApiConnection();
        $URL = "groups/{$this->groupID}/action";
        $data = '{"scene": "' . $sceneID .'"}';
        $result = $conn->sendPutCmd($URL, $data);

        return $result;
    }
}
?>