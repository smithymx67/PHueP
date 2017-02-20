<?php
/**
 * Class Client
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.5
 */

require_once "Bridge.php";
require_once "Light/Light.php";
require_once "Light/LightState.php";
require_once "Scene/Scene.php";
require_once "Scene/SceneLightState.php";
require_once "Scene/AppData.php";
require_once "Group/Group.php";
require_once "Group/GroupAction.php";
require_once "Group/GroupState.php";
require_once "Schedule/Schedule.php";
require_once "Schedule/ScheduleCommand.php";
require_once "ApiConnection.php";
require_once "HueError.php";

class Client {
    /**
     * Connection to API sender functions
     *
     * @var ApiConnection
     */
    private $conn;

    /**
     * Client constructor.
     */
    function __construct() {
        $this->conn = new ApiConnection;
    }

    /**
     * Method to get all the lights from the current bridge
     *
     * @return array
     */
    function getAllLights() {
        $lights = $this->conn->sendGetCmd("lights");

        $allLights = array();
        foreach($lights as $lightID => $light) {
            $lightState = $this->createNewLightState($lightID, $light);
            $newLight = $this->createNewLight($lightID, $light, $lightState);
            array_push($allLights, $newLight);
        }

        return $allLights;
    }

    /**
     * Method to get all the scenes from the current bridge
     *
     * @return array
     */
    function getAllScenes() {
        $scenes = $this->conn->sendGetCmd("scenes");

        $allScenes = array();
        foreach($scenes as $sceneID => $scene) {
            $appData = $this->createNewAppData($scene);

            $sceneLightState = $this->conn->sendGetCmd("scenes/{$sceneID}");
            $sceneLightStates = array();
            foreach($sceneLightState["lightstates"] as $lightID => $light) {
                $sceneState = $this->createNewSceneLightState($sceneID, $lightID, $light);
                array_push($sceneLightStates, $sceneState);
            }

            $newScene = $this->createNewScene($sceneID, $scene, $sceneLightStates, $appData);
            array_push($allScenes, $newScene);
        }

        return $allScenes;
    }

    /**
     * Method to get all the groups from the current bridge
     *
     * @return array
     */
    function getAllGroups() {
        $groups = $this->conn->sendGetCmd("groups");
        $allGroups = array();

        foreach($groups as $groupID => $group) {
            $groupAction = $this->createNewGroupAction($groupID, $group);
            $groupState = $this->createNewGroupState($group);
            $newGroup = $this->createNewGroup($groupID, $group, $groupState, $groupAction);
            array_push($allGroups, $newGroup);
        }

        return $allGroups;
    }

    /**
     * Method to get all the schedules from the current bridge
     *
     * @return array
     */
    function getAllSchedule() {
        $schedules = $this->conn->sendGetCmd("schedules");
        $allSchedules = array();

        foreach($schedules as $scheduleID => $schedule) {
            $scheduleCommand = $this->createNewScheduleCommand($scheduleID, $schedule);
            $newSchedule = $this->createNewSchedule($scheduleID, $schedule, $scheduleCommand);
            array_push($allSchedules, $newSchedule);
        }

        return $allSchedules;
    }

    /**
     * Method to return the requested light
     *
     * @param string $lightID
     * @return Light
     */
    function getLight($lightID) {
        if(is_string($lightID)) {
            $light = $this->conn->sendGetCmd("lights/{$lightID}");
            if(isset($light[0]["error"])){
                $error = $this->generateError($light);
                //print_r($error);
                return null;
            } else {
                $lightState = $this->createNewLightState($lightID, $light);
                $newLight = $this->createNewLight($lightID, $light, $lightState);
                return $newLight;
            }
        } else {
            return null;
        }
    }

    /**
     * Method to return the requested scene
     *
     * @param string $sceneID
     * @return Scene
     */
    function getScene($sceneID) {
        if(is_string($sceneID)) {
            $scene = $this->conn->sendGetCmd("scenes/{$sceneID}");

            if(isset($scene[0]["error"])) {
                $error = $this->generateError($scene);
                //print_r($error);
                return null;
            } else {
                $sceneLightStates = array();
                foreach ($scene["lightstates"] as $lightID => $light) {
                    $sceneState = $this->createNewSceneLightState($sceneID, $lightID, $light);
                    array_push($sceneLightStates, $sceneState);
                }

                $sceneAppData = $this->createNewAppData($scene);

                $newScene = $this->createNewScene($sceneID, $scene, $sceneLightStates, $sceneAppData);
                return $newScene;
            }
        } else {
            return null;
        }
    }

    /**
     * Method to return the requested group
     *
     * @param string $groupID
     * @return Group
     */
    function getGroup($groupID) {
        if(is_string($groupID)) {
            $group = $this->conn->sendGetCmd("groups/{$groupID}");

            if(isset($group[0]["error"])) {
                $error = $this->generateError($group);
                //print_r($error);
                return null;
            } else {
                $groupState = $this->createNewGroupState($group);
                $groupAction = $this->createNewGroupAction($groupID, $group);
                $newGroup = $this->createNewGroup($groupID, $group, $groupState, $groupAction);
                return $newGroup;
            }
        } else {
            return null;
        }
    }

    /**
     * Method to return the requested schedule
     *
     * @param string $scheduleID
     * @return Schedule
     */
    function getSchedule($scheduleID) {
        if(is_string($scheduleID)) {
            $schedule = $this->conn->sendGetCmd("schedules/{$scheduleID}");

            if(isset($schedule[0]["error"])) {
                $error = $this->generateError($schedule);
                //print_r($error);
                return null;
            } else {
                $scheduleCommand = $this->createNewScheduleCommand($scheduleID, $schedule);
                $newSchedule = $this->createNewSchedule($scheduleID, $schedule, $scheduleCommand);
                return $newSchedule;
            }
        } else {
            return null;
        }
    }

    /**
     * Method to return a new instance of the bridge
     *
     * @return Bridge
     */
    function getBridge() {
        return new Bridge();
    }

    /**
     * Method to create a new instance of a light
     *
     * @param string $lightID
     * @param array $light
     * @param LightState $lightState
     * @return Light
     */
    private function createNewLight($lightID, $light, $lightState) {
        $newLight = new Light(
            $lightID, $light["type"], $light["name"],
            $light["modelid"], $light["swversion"],
            $light["manufacturername"], $light["uniqueid"], $lightState);
        return $newLight;
    }

    /**
     * Method to create a new instance of a light state
     *
     * @param string $lightID
     * @param array $light
     * @return LightState
     */
    private function createNewLightState($lightID, $light) {
        $newLightState = new LightState(
            $lightID, $light["state"]["on"], $light["state"]["bri"],
            $light["state"]["hue"], $light["state"]["sat"],
            $light["state"]["xy"], $light["state"]["ct"],
            $light["state"]["alert"], $light["state"]["effect"],
            $light["state"]["colormode"], $light["state"]["reachable"]);
        return $newLightState;
    }

    /**
     * Method to create a new instance of a scene
     *
     * @param string $sceneID
     * @param array $scene
     * @param array $sceneLightStates
     * @param AppData $appData
     * @return Scene
     */
    private function createNewScene($sceneID, $scene, $sceneLightStates, $appData) {
        $newScene = new Scene(
            $sceneID, $scene["name"],
            $scene["owner"], $scene["recycle"],
            $scene["locked"], $appData,
            $scene["picture"], $scene["lastupdated"],
            $scene["version"], $sceneLightStates);
        return $newScene;
    }

    /**
     * Method to create a new instance of a light state for a light in a scene
     *
     * @param string $sceneID
     * @param string $lightID
     * @param array $light
     * @return SceneLightState
     */
    private function createNewSceneLightState($sceneID, $lightID, $light) {
        $lightXY  = array_key_exists("xy", $light)  ? $light["xy"]  : "";
        $lightCT  = array_key_exists("ct", $light)  ? $light["ct"]  : "";
        $lightBri = array_key_exists("bri", $light) ? $light["bri"] : "";

        $sceneState = new SceneLightState($sceneID, $lightID, $light["on"],
            $lightBri, $lightXY, $lightCT);
        return $sceneState;
    }

    /**
     * Method to create a new instance of app data for a scene
     *
     * @param array $scene
     * @return AppData
     */
    private function createNewAppData($scene) {
        if(isset($scene["appdata"]["version"])){
            $newAppData = new AppData(
                $scene["appdata"]["version"], $scene["appdata"]["data"]);
        } else {
            $newAppData = new AppData("", "");
        }
        return $newAppData;
    }

    /**
     * Method to create a new instance of a group action
     *
     * @param string $groupID
     * @param array $group
     * @return GroupAction
     */
    private function createNewGroupAction($groupID, $group) {
        $newGroupAction = new GroupAction(
            $groupID, $group["action"]["on"], $group["action"]["bri"], $group["action"]["hue"],
            $group["action"]["sat"], $group["action"]["effect"], $group["action"]["xy"],
            $group["action"]["ct"], $group["action"]["alert"], $group["action"]["colormode"]);
        return $newGroupAction;
    }

    /**
     * Method to create a new instance of a group state
     *
     * @param array $group
     * @return GroupState
     */
    private function createNewGroupState($group) {
        $newGroupState = new GroupState($group["state"]["any_on"], $group["state"]["all_on"]);
        return $newGroupState;
    }

    /**
     * Method to create a new instance of a group
     *
     * @param string $groupID
     * @param array $group
     * @param GroupState $groupState
     * @param GroupAction $groupAction
     * @return Group
     */
    private function createNewGroup($groupID, $group, $groupState, $groupAction) {
        $groupClass = isset($group["class"]) ? $group["class"] : "";
        $newGroup = new Group(
            $groupID, $group["name"],
            $group["type"], $groupClass,
            $groupState, $groupAction, $group["lights"]);
        return $newGroup;
    }

    /**
     * Method to create a new instance of a schedule command
     *
     * @param string $scheduleID
     * @param array $schedule
     * @return ScheduleCommand
     */
    private function createNewScheduleCommand($scheduleID, $schedule) {
        $newScheduleCommand = new ScheduleCommand(
            $scheduleID, $schedule["command"]["address"],
            $schedule["command"]["method"], $schedule["command"]["body"]);
        return $newScheduleCommand;
    }

    /**
     * Method to create a new instance of a schedule
     *
     * @param string $scheduleID
     * @param array $schedule
     * @param ScheduleCommand $scheduleCommand
     * @return Schedule
     */
    private function createNewSchedule($scheduleID, $schedule, $scheduleCommand) {
        $newSchedule = new Schedule(
            $scheduleID, $schedule["name"], $schedule["description"],
            $schedule["time"], $schedule["created"], $schedule["status"],
            $schedule["autodelete"], $schedule["starttime"], $scheduleCommand);
        return $newSchedule;
    }

    /**
     * Method to generate a new error
     *
     * @param array $element
     * @return HueError
     */
    private function generateError($element) {
        $error = new HueError(
            $element[0]["error"]["type"],
            $element[0]["error"]["address"],
            $element[0]["error"]["description"]);
        return $error;
    }

    /**
     * Create a new scene based on the current state of the lights
     *
     * @param string $sceneName
     * @return array
     */
    function createScene($sceneName) {
        if(is_string($sceneName) && strlen($sceneName) > 0 && strlen($sceneName) <= 32) {
            $allscenes = $this->getAllScenes();
            $sceneNameExists = false;
            foreach($allscenes as $scene) {
                if($scene->getSceneName() == $sceneName){
                    $sceneNameExists = true;
                    break;
                }
            }

            if(!$sceneNameExists) {
                $URL = "scenes";
                $data = '{"name": "' . $sceneName .'","recycle":true, "lights":["1","2","3","4","5","6","7","8","9"]}';
                $result = $this->conn->sendPostCmd($URL, $data);
                return $result;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Method to create a new group
     *
     * @param string $name      The name of the new group
     * @param array  $lights    The lights to be included in the group
     * @return array
     */
    function createGroup($name, $lights) {
        if(is_string($name) && strlen($name) > 0 && strlen($name) <= 32) {
            $allGroups = $this->getAllGroups();
            $groupNameExists = false;
            /** @var $group Group */
            foreach($allGroups as $group) {
                if($group->getGroupName() == $name) {
                    $groupNameExists = true;
                    break;
                }
            }

            if(!$groupNameExists) {
                $groupURL = "groups";
                $data = '{"name": "' . $name .'", 
                  "type": "LightGroup",
                  "lights": ' . $lights .'}';
                $result = $this->conn->sendPostCmd($groupURL, $data);
                return $result;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Method to create a new room
     *
     * @param string $name      The name of the new group
     * @param array  $lights    The lights to be included in the new group
     * @param string $class     The name of the room the lights are in
     * @return array
     */
    function createRoom($name, $lights, $class) {
        $groupClasses = new GroupClass();
        if(is_string($name) && strlen($name) > 0 && strlen($name) <= 32 && $groupClasses->isClassValid($class)) {
            $allGroups = $this->getAllGroups();
            $groupNameExists = false;
            /** @var $group Group */
            foreach($allGroups as $group) {
                if($group->getGroupName() == $name) {
                    $groupNameExists = true;
                    break;
                }
            }

            if(!$groupNameExists) {
                $URL = "groups";
                $data = '{"name": "' . $name .'", 
                  "type": "Room",
                  "class": "' . $class . '",
                  "lights": ' . json_encode($lights) .'}';
                $result = $this->conn->sendPostCmd($URL, $data);
                return $result;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Create a new schedule
     *
     * @param string $name
     * @param string $desc
     * @param string $time
     * @param string $cmdAddress
     * @param string $cmdMethod
     * @param array $cmdBody
     * @return array
     */
    function createSchedule($name, $desc, $time, $cmdAddress, $cmdMethod, $cmdBody) {
        if(is_string($name) && strlen($name) > 0 && strlen($name) <= 32) {
            if(is_string($desc) && strlen($desc) > 0 && strlen(($desc) <= 64)) {
                if(is_string($time) && is_string($cmdAddress) && is_string($cmdMethod) && is_string($cmdBody)) {
                    $URL = "schedules";
                    $data = '{"name": "' . $name .'", 
                              "description": "' . $desc . '",
                              "localtime": "' . $time . '",
                              "command": {
                                "address": "' . $cmdAddress . '",
                                "method": "' . $cmdMethod . '",
                                "body": ' . json_encode($cmdBody) . '}';
                    $result = $this->conn->sendPostCmd($URL, $data);
                    return $result;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Recall a scene on all lights
     *
     * @param $sceneID
     * @return array
     */
    function setGlobalScene($sceneID) {
        $URL = "groups/0/action";
        $data = '{"scene": "' . $sceneID . '"}';
        $result = $this->conn->sendPutCmd($URL, $data);
        return $result;
    }
}
?>