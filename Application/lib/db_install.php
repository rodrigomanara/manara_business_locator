<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manara\Business\locator\Application\lib;

class DBIntstall extends Model {

    protected $tables = array(
        "settings" => "setting_manara_business_locator" , 
        "latitude" => "latitude_manara_business_locator"
    );


    /**
     * createDB
     */
    public function createDB() {
        $this->setting_manara_business_locator()
                ->latitude_manara_business_locator();
    }

    private function setting_manara_business_locator() {

        $charset_collate = $this->db->get_charset_collate();
        $table_name = $this->prefix . $this->tables['settings'] ;

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (  
                `settings_id` int(11) NOT NULL AUTO_INCREMENT,
                `data` datetime DEFAULT NULL,
                `key` text,
                PRIMARY KEY (`settings_id`)
              ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);


        return $this;
    }

    private function latitude_manara_business_locator() {

        $charset_collate = $this->db->get_charset_collate();
        $table_name = $this->prefix . $this->tables['latitude'] ;

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (  
                    `latitude_id` int(11) NOT NULL AUTO_INCREMENT,
                    `data` datetime DEFAULT NULL,
                    `name` varchar(255) DEFAULT NULL,
                    `address1` varchar(40) DEFAULT NULL,
                    `address2` varchar(40) DEFAULT NULL,
                    `address3` varchar(40) DEFAULT NULL,
                    `state` varchar(40) DEFAULT NULL,
                    `county` varchar(40) DEFAULT NULL,
                    `country` varchar(20) DEFAULT NULL,
                    `latitude` varchar(50) DEFAULT NULL,
                    `longitude` varchar(50) DEFAULT NULL,
                    `postcode` varchar(20) DEFAULT NULL,
                    PRIMARY KEY (`latitude_id`)
              ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);


        return $this;
    }

    public function deleteDB() {
        
        $this->db->query('DROP TABLE IF EXIST ' . $this->prefix.$this->tables['settings']);
        $this->db->query('DROP TABLE IF EXIST ' . $this->prefix.$this->tables['latitude']);
    }

}
