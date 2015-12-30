<?php

namespace Manara\Business\locator\Application\lib;

class Latitude {

    private $country;
    private $county;
    private $latitude;
    private $logitude;
    private $postcode;

    /**
     * 
     * @param type $postcode
     * @param type $key
     * @return string
     */
    public function googleLatitude($postcode = null, $key = null) {

        if (!is_null($postcode)) {
            $string = str_replace(" ", "", strtoupper($postcode));
            $search_code = urlencode($string);
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $search_code . '&sensor=false&key=' . $key;

            $array = array('address' => $search_code, 'sensor' => 'false');
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, $array);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
            $page = curl_exec($c);
            curl_close($c);


            $json = json_decode($page);


            foreach ($json->results as $value) {
                $this->setComponents($value);
            }
        }


        return $this->buildReturn();
    }

    public function buildReturn() {

        return array(
            'country' => $this->getCountry(),
            'county' => $this->getCounty(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'date' => date('Y-m-d'),
            'postcode' => $this->getPostcode(),
        );
    }

    public function setComponents($components) {



        if (isset($components->address_components)) {
            foreach ($components->address_components as $address) {
                $this->setAddressComponents($address);
            }
        }
        if (isset($components->geometry)) {
            foreach ($components->geometry as $location) {
                $this->setLocation($location);
            }
        }
    }

    /**
     * 
     * @param type $postcode
     * @return \Manara\Business\locator\Application\lib\Latitude
     */
    public function setPostcode($postcode) {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getPostcode() {
        return $this->postcode;
    }

    /**
     * 
     * @param type $location
     * @return \Manara\Business\locator\Application\lib\Latitude
     */
    public function setLocation($location) {

        if (isset($location->lng)) {
            $this->setLongitude($location->lng);
        }
        if (isset($location->lat)) {
            $this->setLatitude($location->lat);
        }
    }

    /**
     * 
     * @param type $lat
     * @return \Manara\Business\locator\Application\lib\Latitude
     */
    public function setLatitude($lat) {
        $this->latitude = $lat;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * 
     * @param type $long
     * @return \Manara\Business\locator\Application\lib\Latitude
     */
    public function setLongitude($long) {
        $this->logitude = $long;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getLongitude() {
        return $this->logitude;
    }

    public function setAddressComponents($components) {
        foreach ($components->types as $type) {
            if ($type === 'country') {
                $this->setCountry($components->long_name);
            } elseif ($type === 'postal_town') {
                $this->setCounty($components->long_name);
            } elseif ($type === 'postal_code') {
                $this->setPostcode($components->long_name);
            }
        }
    }

    /**
     * 
     * @param type $country
     */
    public function setCountry($country) {
        $this->country = $country;
    }

    /**
     * 
     * @return type
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * 
     * @param type $county
     */
    public function setCounty($county) {
        $this->county = $county;
    }

    /**
     * 
     * @return type
     */
    public function getCounty() {
        return $this->county;
    }

}
