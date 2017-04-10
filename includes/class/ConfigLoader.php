<?php
/**
 * Created by PhpStorm.
 * User: j
 * Date: 10/4/17
 * Time: 2:29 PM
 */

namespace Jomisacu;


class ConfigLoader {
	
	// principal environments
	const ENV_PRODUCTION = 'production';
	const ENV_DEVELOPMENT = 'development';
	const ENV_TESTING = 'testing';
	
	protected $config;
	protected $loadedFiles = [];
	protected $environment = ConfigLoader::ENV_PRODUCTION;
	protected $root = '';
	
	
	public function __construct ($root, $environment = null) {
		
		$this->root = $root;
		
		if (isset($environment)) {
			$this->environment = $environment;
		} else {
			if (isset($_SERVER['ENVIRONMENT'])) {
				$this->environment = $_SERVER['ENVIRONMENT'];
			} else if (file_exists($this->root . '/ENVIRONMENT.txt')) {
				$this->environment = trim(file_get_contents($this->root . '/ENVIRONMENT.txt'));
			}
		}
	}
	
	
	public function getEnvironment () {
		
		return $this->environment;
	}
	
	
	public function __get ($key) {
		
		return $this->get($key);
	}
	
	
	public function get ($key) {
		
		if (isset($this->config[$key])) {
			return $this->config[$key];
		}
		
		return null;
	}
	
	
	public function load ($fileToLoad, $forceReload = false) {
		
		if (in_array($fileToLoad, $this->loadedFiles)) {
			return $this;
		}
		
		$ext = '';
		
		if (strpos($fileToLoad, '.php') === false) {
			$ext = '.php';
		}
		
		if (!$forceReload && isset($this->loadedFiles[$fileToLoad])) {
			return $this;
		}
		
		$this->loadedFiles[$fileToLoad] = $fileToLoad;
		
		$config = [];
		
		// force production values
		if ($this->environment != 'production') {
			if (file_exists($this->root . '/production/' . $fileToLoad . $ext)) {
				include $this->root . '/production/' . $fileToLoad . $ext;
			}
		}
		
		// check for other environments
		if (file_exists($this->root . '/' . $this->environment . '/' . $fileToLoad . $ext)) {
			include $this->root . '/' . $this->environment . '/' . $fileToLoad . $ext;
		}
		
		foreach ($config as $key => $value) {
			$this->config[$key] = $value;
		}
		
		return $this;
	}
}