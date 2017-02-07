<?php

/**
 * Class Schedule
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.1
 */
class Schedule {
    /**
     * The ID of the schedule in the bridge
     *
     * @var string
     */
    private $scheduleID;

    /**
     * The name of the schedule
     *
     * @var string
     */
    private $scheduleName;

    /**
     * The description of the schedule
     *
     * @var string
     */
    private $scheduleDescription;

    /**
     * The time to activate the commands
     *
     * @var string
     */
    private $scheduleTime;

    /**
     * The time the schedule was created
     *
     * @var string
     */
    private $scheduleCreated;

    /**
     * The status of the schedule
     *
     * @var string
     */
    private $scheduleStatus;

    /**
     * Should it be deleted once run
     *
     * @var bool
     */
    private $scheduleAutoDelete;

    /**
     * The time from when the schedule should run
     *
     * @var string
     */
    private $scheduleStartTime;

    /**
     * The commands to run when triggered
     *
     * @var ScheduleCommand
     */
    private $scheduleCommand;

    /**
     * Schedule constructor.
     *
     * @param $scheduleID
     * @param $scheduleName
     * @param $scheduleDescription
     * @param $scheduleTime
     * @param $scheduleCreated
     * @param $scheduleStatus
     * @param $scheduleAutoDelete
     * @param $scheduleStartTime
     * @param $scheduleCommand
     */
    function __construct($scheduleID, $scheduleName, $scheduleDescription,
                         $scheduleTime, $scheduleCreated, $scheduleStatus,
                         $scheduleAutoDelete, $scheduleStartTime, $scheduleCommand) {
        $this->scheduleID               = (String)  $scheduleID;
        $this->scheduleName             = (String)  $scheduleName;
        $this->scheduleDescription      = (String)  $scheduleDescription;
        $this->scheduleStatus           = (String)  $scheduleStatus;
        $this->scheduleAutoDelete       = (Boolean) $scheduleAutoDelete;
        $this->scheduleTime             = $scheduleTime;
        $this->scheduleCreated          = $scheduleCreated;
        $this->scheduleStartTime        = $scheduleStartTime;
        $this->scheduleCommand          = $scheduleCommand;
    }

    /**
     * Return the schedules ID
     *
     * @return string
     */
    function getScheduleID() {
        return $this->scheduleID;
    }

    /**
     * Retunr the schedules name
     *
     * @return string
     */
    function getScheduleName() {
        return $this->scheduleName;
    }

    /**
     * Return the schedules description
     *
     * @return string
     */
    function getScheduleDescription() {
        return $this->scheduleDescription;
    }

    /**
     * Return the schedules run time
     *
     * @return string
     */
    function getScheduleTime() {
        return $this->scheduleTime;
    }

    /**
     * Return the schedules created time
     *
     * @return string
     */
    function getScheduleCreated() {
        return $this->scheduleCreated;
    }

    /**
     * Return the schedules status
     *
     * @return string
     */
    function getScheduleStatus() {
        return $this->scheduleStatus;
    }

    /**
     * Return true if the schedule is set to auto delete
     *
     * @return bool
     */
    function getScheduleAutoDelete() {
        return $this->scheduleAutoDelete;
    }

    /**
     * Return the start time of the schedule
     *
     * @return string
     */
    function getScheduleStartTime() {
        return $this->scheduleStartTime;
    }

    /**
     * Return the command triggered by this schedule
     *
     * @return ScheduleCommand
     */
    function getScheduleCommand() {
        return $this->scheduleCommand;
    }

    /**
     * Sets the name of the schedule
     *
     * @param string $name
     * @return array
     */
    function setScheduleName($name) {
        if(is_string($name) && $name > 0 && $name <= 32) {
            $conn = new ApiConnection();
            $URL = "schedules/" . $this->scheduleID;
            $data = '{"name": "' . $name .'"}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Set the description of the schedule
     *
     * @param string $description
     * @return array
     */
    function setScheduleDescription($description) {
        if(is_string($description) && $description > 0 && $description <= 32) {
            $conn = new ApiConnection();
            $URL = "schedules/" . $this->scheduleID;
            $data = '{"description": "' . $description .'"}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Set the schedule time
     *
     * @param string $time
     * @return array
     */
    function setScheduleTime($time) {
        $conn = new ApiConnection();
        $URL = "schedules/" . $this->scheduleID;
        $data = '{"localtime": "' . $time .'"}';
        $result = $conn->sendPutCmd($URL, $data);

        return $result;
    }

    /**
     * Sets the schedules status
     *
     * @param string $status
     * @return array
     */
    function setScheduleStatus($status) {
        // String 5 to 16
        if(is_string($status) && $status >= 5 && $status <= 16) {
            $conn = new ApiConnection();
            $URL = "schedules/" . $this->scheduleID;
            $data = '{"status": "' . $status .'"}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Sets if the schedule should be auto deleted once run
     *
     * @param bool $auto
     * @return array
     */
    function setScheduleAutoDelete($auto) {
        if(is_bool($auto)){
            $conn = new ApiConnection();
            $URL = "schedules/" . $this->scheduleID;
            $data = '{"autodelete": "' . $auto .'"}';
            $result = $conn->sendPutCmd($URL, $data);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * Delete the schedule
     *
     * @return array
     */
    function deleteSchedule() {
        $conn = new ApiConnection();
        $URL = "schedules/" . $this->scheduleID;
        $result = $conn->sendDeleteCmd($URL);
        return $result;
    }
}
?>