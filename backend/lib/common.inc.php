<?php

function printObject($object) {
	echo "<pre><h4>";
	print_r($object);
	echo "</h4></pre>";
}


function printRandomDirections(int $quantity) {
	for ($i = 0; $i < $quantity; $i++) {
		printObject(json_encode((new RandomDirection()) -> toArray()));	
	}
}