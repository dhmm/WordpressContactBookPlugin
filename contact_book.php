<?php
if( !class_exists('DHMM_ContactBook')) {

    class DHMM_ContactBook { 
        
        static function init() {            
            add_action('admin_menu' , 'DHMM_ContactBook::addMenu');  
            wp_register_style('dhmm_cb', plugins_url('admin/css/style.css',__FILE__ ));         
            wp_register_script( 'dhmm_cb', plugins_url('admin/js/scripts.js',__FILE__ ));  
            wp_enqueue_scripts('dhmm_cb');       
        }

        static function activate() {  
            self::installDB();                            
        }
        static function deactivate() {
            self::uninstallDB();            
        }
        static function installDB() {
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
            global $wpdb;
            $tableName = $wpdb->prefix.'contacts';
            $charsetCollate = $wpdb->get_charset_collate();            
            $sql = "CREATE TABLE ".$tableName." (
                id INT NOT NULL AUTO_INCREMENT,
                surname VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                address VARCHAR(255) NULL,
                phone_1 VARCHAR(50) NULL,
                phone_2 VARCHAR(50) NULL,
                notes TEXT NULL,
                PRIMARY KEY (id)
                ) ". $charsetCollate.";";   
            add_option('dhmm_db_version' , '1.0');
            dbDelta( $sql );                               
        }
        static function uninstallDB() {
            global $wpdb;
            $table_name = $wpdb->prefix."contacts";        
            $wpdb->query("DROP TABLE IF EXISTS ".$table_name);
            delete_option('dhmm_db_version');
        }
        static function addMenu() {
            add_menu_page(
                'DHMM - Contact Book',
                'Contact Book',
                'manage_options',
                plugin_dir_path(__FILE__) . 'admin/view.php',
                null,
                plugin_dir_url(__FILE__) . 'admin/icon.png',
                2000
            );
            
        }
      
       
    }

   
}

