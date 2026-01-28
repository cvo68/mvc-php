<?php

require '../bootstrap.php';
use core\Controller;

$controller = new Controller;
$controller = $controller->load();
dd($controller);