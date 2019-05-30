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

 define( 'DHMMCB_PLUGIN_DIR', dirname(__FILE__).'/' );  
 define( 'DHMMCB_PLUGIN_URL', plugin_dir_url(__FILE__));  
 



if( !class_exists('DHMM_ContactBook')) {

    class DHMM_ContactBook { 
        
        static function init() {            
            add_action('admin_menu' , 'DHMM_ContactBook::addMenu');  
            add_action('admin_init' , 'DHMM_ContactBook::addStyles');
            add_action('admin_init' , 'DHMM_ContactBook::addScripts');
            add_action('dhmmcb_ajax_create_contact' , '');
            
            
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
                DHMMCB_PLUGIN_DIR . 'admin/views/view.php',
                null,
                DHMMCB_PLUGIN_URL . 'admin/images/icon.png',
                2000
            );
            
        }
        static function addStyles() {
            wp_register_style('dhmm_cb', DHMMCB_PLUGIN_URL.'admin/css/style.css');
            wp_enqueue_style('dhmm_cb');
        }
        static function addScripts() {
            $ajaxObject = [
                'ajaxUrl' => admin_url( 'admin-ajax.php' )              
            ];
            //Load Contacts
            add_action("wp_ajax_load_contacts" , "DHMM_ContactBook::loadContacts");
            wp_enqueue_script('dhmm_cb_load' ,  DHMMCB_PLUGIN_URL.'admin/js/load_contacts.js' , ['jquery'] );            
            wp_localize_script( 'dhmm_cb_load', 'ajaxObject', $ajaxObject );
            
            //Create Contact
            add_action("wp_ajax_create_contact", "DHMM_ContactBook::createContact");
            wp_enqueue_script('dhmm_cb_create' ,  DHMMCB_PLUGIN_URL.'admin/js/create_contact.js' , ['jquery'] );            
            wp_localize_script( 'dhmm_cb_create', 'ajaxObject', $ajaxObject );
            
            //Delete Contact
            add_action("wp_ajax_remove_contact", "DHMM_ContactBook::removeContact");            
            wp_enqueue_script('dhmm_cb_remove' ,  DHMMCB_PLUGIN_URL.'admin/js/remove_contact.js' , ['jquery'] );            
            wp_localize_script( 'dhmm_cb_remove', 'ajaxObject', $ajaxObject );
            
            //Delete ALL Contacts
            add_action("wp_ajax_remove_all_contacts", "DHMM_ContactBook::removeAllContacts");            
            wp_enqueue_script('dhmm_cb_remove_all' ,  DHMMCB_PLUGIN_URL.'admin/js/remove_all_contacts.js' , ['jquery'] );            
            wp_localize_script( 'dhmm_cb_remove_all', 'ajaxObject', $ajaxObject );

        }                      

        //AJAX Responses
        static function okResponse($msg="" , $data = null) {
            return [ "error" => false , "message" => $msg , "data" => $data];
        }
        static function errorResponse($msg) {
            return [ "error" => true , "message" => $msg , "data" => null];            
        }
        //AJAX handling functions
        static function loadContacts() {
            require(DHMMCB_PLUGIN_DIR . 'admin/views/contact_line.php');

            global $wpdb;
            $tableName = $wpdb->prefix.'contacts';
            $result = $wpdb->get_results(
                "SELECT * FROM ".$tableName
            ); 

            $dataHTML = "";
            if($result) {
                $line=1;
                foreach($result as $contact) { 
                    $dataHTML .= getContactTrLine($line, $contact);
                    $line++;
                  }
            }

            echo json_encode(self::okResponse("",$dataHTML));
            wp_die();
        }
        static function createContact() {
            if(is_user_logged_in()) {                                                
                if(isset($_POST['contact'])) {  
                    $data = "";                                                        
                    parse_str($_POST['contact'] , $data);
          
                    if(
                        isset($data['surname']) && !empty($data['surname'])  &&
                        isset($data['name']) && !empty($data['name'])  &&
                        isset($data['address']) && !empty($data['address'])  
                    ) {
                        $response = null;
                        
                        global $wpdb;                                            
                        $tableName = $wpdb->prefix.'contacts';     
                        $sql = "
                            INSERT INTO ".$tableName." 
                            ( surname , name , address , phone_1 , phone_2 , notes )
                            VALUES 
                            ( '".$data['surname']."' , '".$data['name']."' , '".$data['address']."' , '".$data['phone1']."' , '".$data['phone2']."' , '".$data['notes']."' )
                            ";                          
                        $wpdb->query( $sql );  
                        $response =  self::okResponse();                       
                    } else {
                        $response = self::errorResponse("Fill surname , name , address");
                    }
                } else {
                    $response = self::errorResponse("No form data");         
                }                
                echo json_encode($response);
               

            }
            wp_die();
        }
        static function removeContact() {
            if(is_user_logged_in()) {                                                
                if(isset($_POST['id'])) {                      
                    $id = $_POST['id'];    
                    $response = null;                    
                    global $wpdb;                                            
                    $tableName = $wpdb->prefix.'contacts';     
                    $sql = "
                        DELETE FROM ".$tableName." 
                        WHERE id = '$id'
                        ";                          
                    $wpdb->query( $sql );  
                    $response =  self::okResponse();                       
                
                } else {
                    $response = self::errorResponse("No contact detected");         
                }                
                echo json_encode($response);
              }
            wp_die();
        }
        static function removeAllContacts() {
            if(is_user_logged_in()) {                                                                                             
                $response = null;                    
                global $wpdb;                                            
                $tableName = $wpdb->prefix.'contacts';     
                $sql = "
                    TRUNCATE TABLE ".$tableName." ";                          
                $wpdb->query( $sql );  
                $response =  self::okResponse();                       
                                       
                echo json_encode($response);
              }
            wp_die();
        }
    }

   
}

 DHMM_ContactBook::init();
 register_activation_hook(__FILE__ , 'DHMM_ContactBook::activate');
 register_deactivation_hook(__FILE__ , 'DHMM_ContactBook::deactivate');

