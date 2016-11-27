<?php

require_once ('core/Autoloader.php');
$autoloader = Autoloader::getInstance();

$config = require('config/config.php');
$application = new Application($config);

$application->processRequest();

