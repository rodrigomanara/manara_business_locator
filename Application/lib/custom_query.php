<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manara\Business\locator\Application\lib;

use Manara\Business\locator\Application\lib\Model;

class CustomQuery extends Model {

    public function getListofRetailers($var){
        $sql = "SELECT  a.latitude_id, a.name, a.address1, a.address2, a.address3, a.state, a.county, a.country, a.latitude, a.longitude, a.postcode , (
            3963
                * acos(
                         cos(radians('{$var['latitude']}'))
                       * cos(radians(a.latitude))
                       * cos(radians(a.longitude) - radians('{$var['longitude']}'))
                     + sin(radians('{$var['latitude']}')) * sin(radians(a.latitude))))
                AS distance
        FROM {$this->prefix}latitude_manara_business_locator a
        having distance <  '{$var['distance']}' ;"; 
        
        return $this->db->get_results($sql);
    }
    
  
}
