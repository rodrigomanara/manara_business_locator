<?php

/*
  Plugin Name: Manara Business Locator
  Plugin URI: http://rodrigomanara.co.uk/
  Description: Hooks the <code>[manara_business_locator]</code> shortcode
  Author: Rodrigo Manara
  Author URI: http://rodrigomanara.co.uk
  Version: 1.0
 */

defined('ABSPATH') or die('No script kiddies please!');


/**
 * set global 
 */
define('manara_business_locator_path_pluggin', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'manara_business_locator' . DIRECTORY_SEPARATOR);
define('manara_business_locator_path_pluggin_path_view', manara_business_locator_path_pluggin . "Application" . DIRECTORY_SEPARATOR . "view");


/* * *********************************************************
 *  add composer *********
 * *************
 */
include_once WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'manara_business_locator' . DIRECTORY_SEPARATOR . 'vendor/autoload.php';


/** sessao administrativa * */
add_action('admin_menu', 'manara_business_locator_admin_menu');

function manara_business_locator_admin_menu() {
    add_menu_page('Business Locater', 'Business Locater', 'manage_categories', 'manara_business_locator/Application/admin/panel.php', '', plugins_url('manara_business_locator/Application/public/images/look.png'), 6);
}

/** register css for menu admin panel **/
add_action('admin_enqueue_scripts', 'manara_business_locator_admin_style');
function manara_business_locator_admin_style() {

    $array[] = plugins_url('/manara_business_locator/Application/public/css/admin.css'); 
    for ($i = 0; $i < count($array); $i++) {
        wp_register_style('manara_business_locator_admin_style' . $i, $array[$i]);
    }

    for ($i = 0; $i < count($array); $i++) {
        wp_enqueue_style('manara_business_locator_admin_style' . $i);
    }
}

add_action('admin_enqueue_scripts', 'manara_business_locator_admin_script');
function manara_business_locator_admin_script() {

    
    $array[] = plugins_url('/manara_business_locator/Application/public/js/bootstrap.min.js'); 
    for ($i = 0; $i < count($array); $i++) {
        wp_register_script('manara_business_locator_admin_script' . $i, $array[$i]);
    }

    for ($i = 0; $i < count($array); $i++) {
        wp_enqueue_script('manara_business_locator_admin_script' . $i);
    }
}


add_action('wp_enqueue_scripts', 'manara_business_locator_script');
function manara_business_locator_script() {

    
    $array[] = plugins_url('/manara_business_locator/Application/public/js/jquery.ui.map.js '); 
    for ($i = 0; $i < count($array); $i++) {
        wp_register_script('manara_business_locator_script' . $i, $array[$i]);
    }

    for ($i = 0; $i < count($array); $i++) {
        wp_enqueue_script('manara_business_locator_script' . $i);
    }
}

/** register pluggin **/
$dbSetUp = new Manara\Business\locator\Application\lib\DBIntstall();
register_activation_hook(__FILE__ , array(&$dbSetUp , 'createDB'));
register_deactivation_hook(__FILE__ , array(&$dbSetUp , 'deleteDB'));


$add_shortcode = new Manara\Business\locator\Application\lib\display();
add_shortcode("manara_business_locator", array($add_shortcode, "getPanelDisplay"));