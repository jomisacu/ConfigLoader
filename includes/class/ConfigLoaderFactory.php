<?php
/**
 * Created by PhpStorm.
 * User: j
 * Date: 10/4/17
 * Time: 2:34 PM
 */

namespace Jomisacu;


class ConfigLoaderFactory {
	
	public static function create ($root, $env = null, $autoloadFiles = null) {
		
		static $instances = array ();
		
		$key = md5(serialize(func_get_args()));
		
		if (!isset($instances[$key])) {
			$instances[$key] = new ConfigLoader($root, $env);
			
			if (isset($autoloadFiles) && $autoloadFiles && is_array($autoloadFiles)) {
				foreach ($autoloadFiles as $autoloadFile) {
					$instances[$key]->load($autoloadFile);
				}
			}
		}
		
		return $instances[$key];
	}
}