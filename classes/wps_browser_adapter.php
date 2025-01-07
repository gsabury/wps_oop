<?php
class WPS_Browser_Adapter{
    private $_browser;
    public function __construct()
    {
        require_once 'browser.php';
        $this->_browser = new Browser();
    }

    public function getBrowser(){
        if(method_exists($this->_browser,'getBrowser')){
            return $this->_browser->getBrowser();
        }
        return FALSE;
    }
}