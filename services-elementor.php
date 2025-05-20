<?php
/**
 * Plugin Name: Services Widget for elementor
 * Authoe: Shereef Hamed
 * Text Domain: services-elementor
 */

 if(!defined('ABSPATH')){
    exit;
 }

 define('SERVICES_FOR_ELEMENTOR_PATH', plugin_dir_path(__FILE__));
 define('SERVICES_FOR_ELEMENTOR_URL', plugin_dir_url(__FILE__));
 define('SERVICES_FOR_ELEMENTOR_VERSION', '1.0.0');;

 require_once(SERVICES_FOR_ELEMENTOR_PATH. 'includes/services-for-elementor-class.php');

 if(class_exists('ServicesForElementor')){
    register_activation_hook(__FILE__, array('ServicesForElementor', 'activate'));
    register_deactivation_hook(__FILE__, array('ServicesForElementor', 'deactivate'));
    register_uninstall_hook(__FILE__, array('ServicesForElementor', 'uninstall'));
    $servicesForElementor = new ServicesForElementor();
}
 