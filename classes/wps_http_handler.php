<?php
class WPS_Http_Handler
{

    public function get($url, $data)
    {
        $response = wp_remote_get($url, $data);
        if (is_array($response) && !is_wp_error($response)) {
            return isset($response['body']) ? json_decode($response['body']) : array();
        }
        return false;
    }

    public function post($url, $data)
    {
        $response = wp_remote_post($url, array(
            'body' => $data
        ));
        if (is_array($response) && !is_wp_error($response)) {
            return $response;
        }
        return false;
    }
}
