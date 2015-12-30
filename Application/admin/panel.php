<?php

$get_function  = sanitize_text_field(isset($_GET['p']) ? $_GET['p'] : 'panel' );
new Manara\Business\locator\Application\lib\Delegator($get_function);


 
?>
