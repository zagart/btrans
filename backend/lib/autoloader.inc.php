<?php
error_reporting(E_ALL);

spl_autoload_register(function ($name) {
	$path = generate_include_path($name, "class");
	if (!is_file($path)) {
		$path = generate_include_path($name, "interface");
	} 
	require_once $path;	
});

function generate_include_path(string $name, string $type) : string {
	if ($type === "class") {
		$subfolder = "classes";
	} else {
		$subfolder = "interfaces";
	}
	return $_SERVER['DOCUMENT_ROOT']
		.DIRECTORY_SEPARATOR."backend"
		.DIRECTORY_SEPARATOR."$subfolder"
		.DIRECTORY_SEPARATOR."$name.$type.php";
}