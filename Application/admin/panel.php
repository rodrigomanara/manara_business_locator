<?php

$get_function = isset($_GET['p']) ? $_GET['p'] : 'panel';

new Manara\Business\locator\Application\lib\Delegator($get_function);


 
?>
