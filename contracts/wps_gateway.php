<?php
abstract class WPS_Gateway{
    protected $options;
    public function __construct()
    {
        $this->options = WPS_Settings::load();
    }

    public abstract function request();
    public abstract function verify();
}