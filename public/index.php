<?php

require '../bootstrap.php';
use core\Controller;

dd(app\classes\Uri::uri());

$controller = new Controller;
$controller = $controller->load();
dd($controller);