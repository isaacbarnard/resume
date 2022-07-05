<?php

require_once(__DIR__ . '/../lib/init.php');

use resume\routing\Router;

$r = new Router(false, 'NotFound');
$r->route();

?>