<?php

require_once ".."
	.DIRECTORY_SEPARATOR."interfaces"
	.DIRECTORY_SEPARATOR."Locatable.interface.php";

class GPSNavigator implements Locatable {
	
	public function getPoint() : Point {
		return new Point(0.0, 0.0);
	}
	
}
new GPSNavigator();