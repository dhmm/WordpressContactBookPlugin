<?php
if( !class_exists('DHMM_ContactBook')) {

    class DHMM_ContactBook {        

        static function register() {
            self::installdb();
        }
        static function unregister() {
            self::uninstalldb();
        }

        static function installdb() {
            global $wpdb;
            $table_name = $wpdb->prefix."contacts";
            $charset_collate = $wpdb->get_charset_collate();            
            $sql = "CREATE TABLE $table_name (
                id INT NOT NULL AUTO_INCREMENT,
                surname VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                address VARCHAR(255) NULL,
                phone_1 VARCHAR(50) NULL,
                phone_2 VARCHAR(50) NULL,
                notes TEXT NULL,
                PRIMARY KEY (id))
                $charset_collate ; ";
        
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
            
            dbDelta( $sql );     
            add_option( 'dhmm_db_version' , '1.0');  
        }
        static function uninstalldb() {
            global $wpdb;
            $table_name = $wpdb->prefix."contacts";
        
            $wpdb->query("DROP TABLE IF EXISTS ".$table_name);
        }
    }

    register_activation_hook(__FILE__ , DHMM_ContactBook::register());
    register_deactivation_hook(__FILE__ , DHMM_ContactBook::unregister());
}