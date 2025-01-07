<?php
class WPS_Settings_General extends WPS_Settings_Contract {
    public function get_name()
    {
        return 'general';
    }

    public function get_title()
    {
        return 'General';
    }

    public function load_body()
    {
        $wps_options = get_option( 'wps_oop_options' ); //print_r( $wps_options);
        include WPS_OOP_TPL.'settings_general.php';
    }

    public function save_settings()
    {
        $wps_oop_options = get_option('wps_oop_options');
        $wps_options['notification']['is_plugin_active'] = $wps_oop_options['notification']['is_plugin_active'];
        $wps_options[ 'general' ][ 'is_plugin_active' ] = isset( $_POST[ 'wps_oop_active_plugin' ] ) ? 1 : 0;
        update_option( 'wps_oop_options', $wps_options );
    }
}