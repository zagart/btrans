<?php
error_reporting(E_ALL);

spl_autoload_register(function ($name) {
	$path = generate_include_path($name, "class");
	if (!is_file($path)) {
		$path = generate_include_path($name, "interface");
		if (!is_file($path)) {
			$path = generate_include_path($name, "exception");
			if (!is_file($path)) {
				throw new IllegalArgumentException("Autoloader not found element $name");
			}
		} 
	} 
	require_once $path;	
});

function generate_include_path(string $name, string $type) : string {
	switch ($type) {
		case "class":
			$subfolder = "classes";
			break;
		case "interface":
			$subfolder = "interfaces";
			break;
		case "exception":
			$subfolder = "classes"
				.DIRECTORY_SEPARATOR."exceptions";
			break;
		default:
			throw new IllegalArgumentException("Type $type not found");
	}
	return $_SERVER['DOCUMENT_ROOT']
		.DIRECTORY_SEPARATOR."backend"
		.DIRECTORY_SEPARATOR."$subfolder"
		.DIRECTORY_SEPARATOR."$name.$type.php";
}