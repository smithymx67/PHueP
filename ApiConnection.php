<?php

/**
 * Class ApiConnection
 *
 * @author      Sam Smith (smithymx67) <sam@samsmith.me>
 * @copyright   Copyright (c) 2017 Sam Smith
 * @version     v1.0
 */
class ApiConnection {
    /**
     * API Key or Username
     *
     * @var string
     */
    private $apiKey = "<< ADD YOUR API KEY HERE >>";

    /**
     * IP address of the bridge
     *
     * @var string
     */
    private $bridgeIp = "<< ADD YOU BRIDGE IP HERE >>";

    /**
     * Base URL to send requests too
     *
     * @var string
     */
    private $baseURL;

    /**
     * ApiConnection constructor.
     */
    function __construct() {
        $this->baseURL = $this->bridgeIp . "/api/" . $this->apiKey . "/";
    }

    /**
     * Send a GET request
     *
     * @param string $resource
     * @return array
     */
    function sendGetCmd($resource) {
        $url = $this->baseURL . $resource;

        $request = curl_init($url);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($request);

        return json_decode($result, true);
    }

    /**
     * Send a POST request
     *
     * @param string $resource
     * @param string $data
     * @return array
     */
    function sendPostCmd($resource, $data) {
        $url = $this->baseURL . $resource;

        $request = curl_init($url);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($request, CURLOPT_FAILONERROR, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, $data);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );

        $result = curl_exec($request);
        return json_decode($result, true);
    }

    /**
     * Send a PUT request
     *
     * @param string $resource
     * @param string $data
     * @return array
     */
    function sendPutCmd($resource, $data) {
        $url = $this->baseURL . $resource;

        $request = curl_init($url);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($request, CURLOPT_FAILONERROR, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, $data);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );

        $result = curl_exec($request);
        return json_decode($result, true);
    }

    /**
     * Send a DELETE request
     *
     * @param string $resource
     * @return array
     */
    function sendDeleteCmd($resource) {
        $url = $this->baseURL . $resource;

        $request = curl_init($url);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($request, CURLOPT_FAILONERROR, true);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($request);
        return json_decode($result, true);
    }
}
?>
