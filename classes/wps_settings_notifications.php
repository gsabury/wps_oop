<?php
class WPS_Settings_Notifications extends WPS_Settings_Contract {
    public  function get_name()
    {
        return 'notifications';
    }
    public function get_title()
    {
        return 'Notifications';
    }

    public function load_body()
    {
        include  WPS_OOP_TPL.'settings_notifications.php';
    }

    public function save_settings()
    {
        echo 'Hello From Notifications';
    }
}