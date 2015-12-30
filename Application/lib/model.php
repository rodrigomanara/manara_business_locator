<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manara\Business\locator\Application\lib;

class Model {

    public $db, $prefix;

    public function __construct() {
        global $wpdb;

        global $wpdb;
        $this->db = $wpdb;
        $this->prefix = $wpdb->prefix;
    }

    /**
     * 
     * @param string $table
     * @param string $prefix
     * @param array $data
     */
    public function __save($table, $data = array()) {

        $sql = "replace into {$this->prefix}{$table} ";

        foreach ($data as $key => $value) {
            $_key[] = $key;
            $_value[] = $value;
        }

        $sql .= "(`" . implode("`,`", $_key) . "`) VALUES ( '" . implode("','", $_value) . "')";
    
       
        $this->db->query($sql);
    }

    public function __select($table, $data = array()) {
        $sql = "select * from {$this->prefix}{$table} where 0=0";

        if (!empty($data)) {
            foreach($data as $key => $value) {
                $sql .= " and  $key = $value ";
            }
        }

        $query = $this->db->get_row($sql , OBJECT );
        return $query;
    }
    
    public function __selects($table, $data = array()) {
        $sql = "select * from {$this->prefix}{$table} where 0=0";

        if (!empty($data)) {
            foreach($data as $key => $value) {
                $sql .= " and  $key = $value ";
            }
        }

        $query = $this->db->get_results($sql , OBJECT );
        return $query;
    }
    
    public function __delete($table, $data = array()) {
        $sql = "delete from {$this->prefix}{$table} where 0=0";

        if (!empty($data)) {
            foreach($data as $key => $value) {
                $sql .= " and  $key = $value ";
            }
        }

        $query = $this->db->get_results($sql , OBJECT );
        return $query;
    }
    
    

}
