<?php

class WPS_Settings
{

    public function __construct()
    {

    }

    public static function perform()
    {
        $wps_options = get_option( 'wps_options' );
        if ( isset( $_POST[ 'submit' ] ) ) {
            $wps_options[ 'general' ][ 'is_plugin_active' ] = isset( $_POST[ 'wps_oop_active_plugin' ] ) ? 1 : 0;
            update_option( 'wps_options', $wps_options );
        }
    }

    public static function load()
    {
        return get_option( 'wps_options' );
    }

}