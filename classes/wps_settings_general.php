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
        include WPS_OOP_TPL.'settings_general.php';
    }

    public function save_settings()
    {
       echo 'Hello From General';
    }
}