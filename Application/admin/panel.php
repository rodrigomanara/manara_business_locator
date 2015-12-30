<?php
$sanitizer = new Manara\Business\locator\Application\Helpers\Sanitizer\__Global();
$get_function  = !is_null($sanitizer->get('p')) ? $sanitizer->get('p') : 'panel' ;
new Manara\Business\locator\Application\lib\Delegator($get_function);
 
?>
