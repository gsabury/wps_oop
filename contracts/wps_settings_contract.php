<?php
abstract class WPS_Settings_Contract{
    public function __construct()
    {

    }

    public abstract function get_name();

    public abstract function get_title();

    public abstract function load_body();

    public abstract function save_settings();

}