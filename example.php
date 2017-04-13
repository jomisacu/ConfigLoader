<?php

/**
 * Created by PhpStorm.
 * User: j
 * Date: 10/4/17
 * Time: 2:52 PM
 */

use Jomisacu\ConfigLoaderFactory;

require 'vendor/autoload.php';

$production  = ConfigLoaderFactory::create('config', 'production', ['system']);
$development = ConfigLoaderFactory::create('config', 'development', ['system']);

// via method call
echo $production->get("config_value") . "<br />";

// via magic method
echo $development->config_value . "<br />";



