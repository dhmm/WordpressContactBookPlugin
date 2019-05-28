<?php
/**
 * Plugin Name: CB Plugin
 * Plugin URI:  http://github.com/dhmm/wp-cb-plugin
 * Description: Simple contact book plugin for wordpress
 * Version:     1.0
 * Author:      dhmm
 * Author URI:  https://github.com/dhmm
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

 require('contact_book.php');

 DHMM_ContactBook::init();
 register_activation_hook(__FILE__ , 'DHMM_ContactBook::activate');
 register_deactivation_hook(__FILE__ , 'DHMM_ContactBook::deactivate');
 