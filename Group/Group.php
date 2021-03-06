<?php
require_once "GroupClass.php";

/**
 * Class Group
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.4
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
     * @param string        $groupID
     * @param string        $groupName
     * @param string        $groupType
     * @param string        $groupClass
     * @param GroupState    $groupState
     * @param GroupAction   $groupAction
     * @param array         $groupLights
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
     * @param string $name  The name of the group - 1 to 32
     * @return array
     */
    function setGroupName($name) {
        if(is_string($name) && strlen($name) > 0 && strlen($name) <= 32){
            $conn = new ApiConnection();
            $groupURL = "groups/" . $this->groupID;
            $data = '{"name": "' . $name .'"}';
            $result = $conn->sendPutCmd($groupURL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Method to set the lights inside a group
     *
     * @param string $lights     String of all lights by ID in the group in JSON
     * @return array
     */
    function setGroupLights($lights) {
        $conn = new ApiConnection();
        $groupURL = "groups/" . $this->groupID;
        $data = '{"lights": ' . $lights .'}';
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
        $groupClass = new GroupClass();
        if($groupClass->isClassValid($class)) {
            $conn = new ApiConnection();
            $groupURL = "groups/" . $this->groupID;
            $data = '{"class": "' . $class .'"}';
            $result = $conn->sendPutCmd($groupURL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Method to delete a group
     *
     * @return array
     */
    function deleteGroup() {
        $conn = new ApiConnection();
        $groupURL = "groups/{$this->groupID}";
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

    /**
     * Return an array of data with the groups information
     *
     * @return string
     */
    function getGroupDataJSON() {
        $data = array();
        $data["id"] = $this->groupID;
        $data["name"] = $this->groupName;
        $data["type"] = $this->groupType;
        $data["class"] = $this->groupClass;
        $data["lights"] = $this->groupLights;

        $data["groupstate"]["any_on"] = $this->groupState->isAnyOn();
        $data["groupstate"]["all_on"] = $this->groupState->isAllOn();

        $data["lightstate"]["brightness"] = $this->groupAction->getGroupBrightness();
        $data["lightstate"]["saturation"] = $this->groupAction->getGroupSaturation();
        $data["lightstate"]["hue"] = $this->groupAction->getGroupHue();
        $data["lightstate"]["xy"] = $this->groupAction->getGroupXY();
        $data["lightstate"]["ct"] = $this->groupAction->getGroupCT();
        $data["lightstate"]["alert"] = $this->groupAction->getGroupAlert();
        $data["lightstate"]["effect"] = $this->groupAction->getGroupEffect();
        $data["lightstate"]["colormode"] = $this->groupAction->getGroupColorMode();

        return json_encode($data);
    }
}
?>