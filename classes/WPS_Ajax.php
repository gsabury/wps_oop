<?php
class WPS_Ajax
{

    public function register_callback()
    {
        add_action('wp_ajax_wps_save_general_settings', array($this, 'wps_save_general_settings'));
    }

    public function wps_save_general_settings()
    {
        check_ajax_referer('wps_save_general_settings', 'security');

        $plugin_is_active = $_POST['plugin_is_active'];
        $options = WPS_Settings::load();
        $options['general']['is_plugin_active'] = ($plugin_is_active == 'true') ? 1 : 0;
        WPS_Settings::save($options);

        $this->make_response([
            'success' => TRUE,
            'message'  => __('Operation done successfully', 'wps_oop'),
        ]);
    }

    private function make_response($data)
    {
        if (is_array($data)) {
            echo json_encode($data);
        } else {
            echo $data;
        }
        die();
    }
}
