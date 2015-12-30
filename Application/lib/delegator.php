<?php

namespace Manara\Business\locator\Application\lib;

Class Delegator {

    const CLASS_NAME = 'Manara\Business\locator\Application\lib\Admin';

    public function __construct($call_function) {
        $class = self::CLASS_NAME;
        $this->class = new $class;
        
        $this->function = $call_function;

        if ($this->checkFunction()) {
            $this->class->{$this->function}();
        }else{
            throw new \Exception("function does not exist");
        }
    }

    private function checkFunction() {
        if (method_exists($this->class, $this->function)) {
            return true;
        }
        return false;
    }

}
