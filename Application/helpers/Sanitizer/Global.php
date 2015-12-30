<?php

namespace Manara\Business\locator\Application\Helpers\Sanitizer;

/**
 * Description of Global
 *
 * @author rodrigo
 */
class __Global {

    //put your code here

    private $post = null, $get = null , $request = null;

    /**
     * 
     */
    public function __construct() {
        if (isset($_POST)) {
            foreach ($_POST as $KEY => $value) {
                $this->post[sanitize_key($KEY)] = sanitize_text_field($value);
            }
        }
        if (isset($_GET)) {
            foreach ($_GET as $KEY => $value) {
                $this->get[sanitize_key($KEY)] = sanitize_text_field($value);
            }
        }
        if (isset($_REQUEST)) {
            foreach ($_REQUEST as $KEY => $value) {
                $this->request[sanitize_key($KEY)] = sanitize_text_field($value);
            }
        }
    }

    /**
     * 
     * @param type $key
     * @return type
     */
    public function post($key = null) {
        if (is_null($key)) {
            return $this->post;
        } elseif (isset($this->post[$key])) {
            return $this->post[$key];
        }
    }

    /**
     * 
     * @param type $key
     * @param type $value
     */
    public function setPost($key, $value) {
        $this->post[$key] = $value;
    }

    /**
     * 
     * @param type $key
     * @return type
     */
    public function get($key = null) {
        if (is_null($key)) {
            return $this->get;
        } elseif (isset($this->get[$key])) {
            return $this->get[$key];
        }
    }
    /**
     * 
     * @param type $key
     * @return type
     */
    public function request($key){
        if (is_null($key)) {
            return $this->request;
        } elseif (isset($this->request[$key])) {
            return $this->request[$key];
        }
    }
    
    
    /**
     * 
     * @param type $key
     * @param type $value
     */
    public function setRequest($key, $value) {
        $this->request[$key] = $value;
    }

}
