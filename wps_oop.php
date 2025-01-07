<?php
/*
Plugin Name: WordPress OOP Plugin
Plugin URI: https://yaransoft.com
Description: WordPress OOP Plugin
Author: Ghafor Sabury
Version: 1.0.0
Author URI:  https://yaransoft.com
*/

defined('ABSPATH') || exit('no direct access');

final class WPS_OOP
{

    private static $_instance = NULL;

    public static function getInstance()
    {
        if (self::$_instance === NULL) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        register_activation_hook(__FILE__, array($this, 'wps_activate'));

        add_action('admin_menu', array($this, 'wps_oop_admin_menu'));

        spl_autoload_register(array($this, 'autoload'));

        // spl_autoload_register( array ( $this, 'autoload_settings' ) );


        $this->define_constants();
    }

    public function wps_activate()
    {
        // add_role('finance_manager', __('Finance Manager', 'wps_oop'), array(
        //     'read' => true,
        //     'save_wps_oop_data' => true
        // ));
        //        $user_id = 1;
        //        $user = new WP_User($user_id);
        //        $user->add_cap('save_wps_oop_data');
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    public function wps_oop_admin_menu()
    {
        add_options_page(
            'Optemize WordPress Posts',
            'Optemize WordPress Posts',
            'manage_options',
            'wps_oop_settings',
            array($this, 'wps_settings_page')
        );
    }

    public function wps_settings_page()
    {
        // WPS_Settings::perform();
        // $wps_options = WPS_Settings::load();
        // $optimizer_class_instance = WPS_Factory::build('optimizer');
        // $gateway_name = $_POST['gateway'];
        // $gateway = WPS_Factory::build('mellat');
        // $gateway->request();
        // $optimizer_class_instance->optimize();
        // $browser = new WPS_Browser_Adapter();
        // echo $browser->getBrowser();

        $current_tab = isset($_GET['tab']) && !empty($_GET['tab']) ? $_GET['tab'] : 'general';


        $tabs = apply_filters('wps_settings_handler', array(
            'general'      => 'WPS_Settings_General',
            'notifications' => 'WPS_Settings_Notifications'
        ));

        if(isset($_POST['submit'])){
            $tab_class = new $tabs[$current_tab];
            $tab_class->save_settings();
        }
        
        $settings_pool = [];
        $current_tpl = NULL;

        include WPS_OOP_TPL . 'settings.php';
    }

    private function define_constants()
    {
        define('WPS_OOP_DIR', trailingslashit(plugin_dir_path(__FILE__)));
        define('WPS_OOP_URL', trailingslashit(plugin_dir_url(__FILE__)));
        define('WPS_OOP_TPL', trailingslashit(WPS_OOP_DIR . 'tpl'));
        define('WPS_OOP_CLASS', trailingslashit(WPS_OOP_DIR . 'classes'));
        define('WPS_OOP_CONTRACT', trailingslashit(WPS_OOP_DIR . 'contracts'));
        define('WPS_OOP_GATEWAY', trailingslashit(WPS_OOP_DIR . 'gateways'));
    }

    public function autoload($class)
    {
        $paths = [
            "WPS_OOP_CLASS",
            "WPS_OOP_CONTRACT",
            "WPS_OOP_GATEWAY",
        ];

        foreach ($paths as $path) {
            if (FALSE !== strpos($class, 'WPS_')) {
                $class_file_path = constant($path) . strtolower($class) . '.php';
                if (is_file($class_file_path) && file_exists($class_file_path)) {
                    include_once $class_file_path;
                }
            }
        }
    }
}

WPS_OOP::getInstance();
