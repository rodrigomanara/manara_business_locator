<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manara\Business\locator\Application\lib;

use \Twig_Environment;
use \Twig_Loader_Filesystem;
use \Twig_Extension_Debug;
Class loadFile {

    protected $loader;
    protected $twig;
    /**
     * 
     */
    public function __construct() {
        $this->loader = new Twig_Loader_Filesystem(manara_business_locator_path_pluggin_path_view);
        $this->twig = new Twig_Environment($this->loader , array('debug' => true));
        $this->twig->addExtension(new Twig_Extension_Debug());
    }
    /**
     * 
     * @param type $name
     * @param type $context
     */
    public function render($name , $context){
        print($this->twig->render($name, $context));    
    }

}
