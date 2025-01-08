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

        register_deactivation_hook(__FILE__, array($this, 'wps_deactivate'));

        add_action('admin_menu', array($this, 'wps_oop_admin_menu'));

        spl_autoload_register(array($this, 'autoload'));

        add_action('init', array($this, 'init_wps'));

        $this->load_assets();

        $this->define_constants();
    }

    public function wps_oop_optimize_callback()
    {
        WPS_Optimizer::optimize();
    }

    public function wps_activate()
    {
        add_role('finance_manager', __('Finance Manager', 'wps_oop'), array(
            'read' => true,
            'save_wps_oop_data' => true
        ));
        $user_id = 1;
        $user = new WP_User($user_id);
        $user->add_cap('save_wps_oop_data');
        //    $user->remove_cap('save_wps_oop_data');

        $wps_oop_options = get_option("wps_oop_options");
        if (empty($wps_oop_options)) {
            $wps_oop_options['general']['is_plugin_active'] = 0;
            $wps_oop_options['notification']['is_plugin_active'] = 0;
            add_option("wps_oop_options", $wps_oop_options);
        }

        WPS_Optimizer::register();
    }

    public function wps_deactivate()
    {
        WPS_Optimizer::unregister();
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
            __('Optemize WordPress Posts', 'wps_oop'),
            __('Optemize WordPress Posts', 'wps_oop'),
            'manage_options',
            'wps_oop_settings',
            array($this, 'wps_settings_page')
        );
    }

    public function init_wps()
    {
        // WPS_Optimizer::optimize();

        add_action('wps_oop_optimize_event', array($this, 'wps_oop_optimize_callback'));

        load_plugin_textdomain('wps_oop', false, dirname(plugin_basename(__FILE__)) . '/languages');

        // $http = new WPS_Http_Handler();
        // $url = "https://reqres.in/api/users";
        // $users = $http->get($url, array());
        // print_r($users->data);

        (new WPS_Ajax())->register_callback();
    }

    public function wps_settings_page()
    {
        // WPS_Settings::perform();
        // $wps_options = WPS_Settings::load(); var_dump( $wps_options);
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

        if (isset($_POST['submit'])) {
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
        define('WPS_JS_URL', trailingslashit(WPS_OOP_URL . 'assets/js'));
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

    public function load_assets()
    {
        add_action('admin_enqueue_scripts', array($this, 'load_scripts'));
    }

    public function  load_scripts()
    {
        wp_register_script('wps_oop_script', WPS_JS_URL . 'wps_oop.js', array('jquery'));
        wp_localize_script('wps_oop_script', 'WPS', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'wp_nonce' => wp_create_nonce('wps_save_general_settings')
        ));
        wp_enqueue_script('wps_oop_script');
    }
}

WPS_OOP::getInstance();
