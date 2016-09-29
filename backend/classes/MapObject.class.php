<?php

abstract class MapObject extends StrictAccessClass {
	
	public abstract function getPositionData() : array;
	
	public abstract function isContainsLocation(Location $location) : bool;
	
}