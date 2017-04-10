# ConfigLoader

Provide a simple interface to handle configuration values.

## Concepts

* Enviroment

A environment represents a directory into directory root.

* Config file

A config file is a pure php file that contains an array named $config with the specific scope values. Example:

```php
<?php // $configRoot . '/' . $environment . '/' . default.php file

$config['system_timezone'] = 'Americas/Santo_Domingo';

```

## installation
    php composer.phar require "jomisacu/configloader"

## Usage

Use this package require atleast the below steps

1. include 
```php
<?php

include "vendor/autoload.php";

```

2. Create a instance

```php
<?php

// for specific environment values.
// represents a sub directory on config files root directory
// it's a string and can exists any number of environments
$environment = \Jomisacu\ConfigLoader::ENV_DEVELOPMENT; 

// directory where resides configuration environments dirs
// -+ config (config root)
//	|-- development
//	|-- production
//	|-- testing
//	|-- qa
//	|-- example
//	|-- ... 
$configFilesRootDir = __DIR__ . '/config';

// configuration files to be loaded automatically
$autoloadFiles = ['default'];

$config = \Jomisacu\ConfigLoaderFactory::create($configFilesRootDir, $environment, $autoloadFiles);
   
```

3. Access to configuration values

```php
<?php

// ...

// load files
$config->load('default');

// via method call
echo $config->get('system_timezone') . "<br />";

// via magic method
echo $config->system_timezone . "<br />";

