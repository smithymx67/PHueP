<?php

/**
 * Class Scene
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */
class Scene {
    /**
     * The ID of the scene in the bridge
     *
     * @var string
     */
    private $sceneID;

    /**
     * The name of the scene
     *
     * @var string
     */
    private $sceneName;

    /**
     * The owner of the scene
     *
     * @var string
     */
    private $sceneOwner;

    /**
     * Is the scene recyclable
     *
     * @var bool
     */
    private $sceneRecycle;

    /**
     * Is the scene locked
     *
     * @var bool
     */
    private $sceneLocked;

    /**
     * App data for the scene
     *
     * @var AppData
     */
    private $sceneAppData;

    /**
     * Picture link for the scene
     *
     * @var string
     */
    private $scenePicture;

    /**
     * Time of last scene update
     *
     * @var string
     */
    private $sceneLastUpdate;

    /**
     * Version of the scene
     *
     * @var int
     */
    private $sceneVersion;

    /**
     * Light that are in the scene
     *
     * @var LightState
     */
    private $sceneLightStates;

    /**
     * Scene constructor.
     * @param $sceneID
     * @param $sceneName
     * @param $sceneOwner
     * @param $sceneRecycle
     * @param $sceneLocked
     * @param $sceneAppData
     * @param $scenePicture
     * @param $sceneLastUpdate
     * @param $sceneVersion
     * @param $sceneLightStates
     */
    function __construct($sceneID, $sceneName, $sceneOwner, $sceneRecycle, $sceneLocked, $sceneAppData, $scenePicture,
                         $sceneLastUpdate, $sceneVersion, $sceneLightStates) {
        $this->sceneID          = (string)  $sceneID;
        $this->sceneName        = (string)  $sceneName;
        $this->sceneOwner       = (string)  $sceneOwner;
        $this->sceneRecycle     = (bool)    $sceneRecycle;
        $this->sceneLocked      = (bool)    $sceneLocked;
        $this->scenePicture     = (string)  $scenePicture;
        $this->sceneVersion     = (int)     $sceneVersion;
        $this->sceneLightStates = $sceneLightStates;
        $this->sceneLastUpdate  = $sceneLastUpdate;
        $this->sceneAppData     = $sceneAppData;
    }

    /**
     * Returns the ID of the scene
     *
     * @return string
     */
    function getSceneID() {
        return $this->sceneID;
    }

    /**
     * Return the name of the scene
     *
     * @return string
     */
    function getSceneName() {
        return $this->sceneName;
    }

    /**
     * Return the owner of the scene
     *
     * @return string
     */
    function getSceneOwner() {
        return $this->sceneOwner;
    }

    /**
     * Return the scenes app data object
     *
     * @return AppData
     */
    function getSceneAppData() {
        return $this->sceneAppData;
    }

    /**
     * Return the scenes picture
     *
     * @return string
     */
    function getScenePicture() {
        return $this->scenePicture;
    }

    /**
     * Returns the scenes last update time
     *
     * @return string
     */
    function getSceneLastUpdate() {
        return $this->sceneLastUpdate;
    }

    /**
     * Returns the version of the scene
     *
     * @return int
     */
    function getSceneVersion() {
        return $this->sceneVersion;
    }

    /**
     * Returns the light state object of the scene
     *
     * @return LightState
     */
    function getSceneLightStates() {
        return $this->sceneLightStates;
    }

    /**
     * Sets the name of the scene
     *
     * @param string $newName
     */
    function setSceneName($newName) {
        // String 1 to 32
        $conn = new ApiConnection();
        $URL = "scenes/" . $this->sceneID;
        $data = '{"name": "' . $newName .'"}';
        $result = $conn->sendPutCmd($URL, $data);

        print_r($result);
    }

    /**
     * Return true if the scene is recyclable
     *
     * @return bool
     */
    function isRecyclable() {
        return $this->sceneRecycle;
    }

    /**
     * Return true if the scene is locked
     *
     * @return bool
     */
    function isLocked() {
        return $this->sceneLocked;
    }

    /**
     * Delete the scene
     *
     * @return array
     */
    function deleteScene() {
        $conn = new ApiConnection();
        $URL = "scenes/{$this->sceneID}";
        $result = $conn->sendDeleteCmd($URL);

        return $result;
    }

    /**
     * Update the scene
     *
     * @return array
     */
    function updateScene() {
        $conn = new ApiConnection();
        $URL = "scenes/{$this->sceneID}";
        $data = '{"storelightstate":true}';
        $result = $conn->sendPutCmd($URL, $data);

        return $result;
    }
}
?>