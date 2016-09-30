<?php

class IdAlgorithm extends Algorithm {
	
	private $startPointTransport;
	private $endPointTransport;
	
		
	private function buildTransport(DataModel $model, int $index) : Transport {
		$transport = $model -> getTransport($index);
		$gps = $model -> getGps($index);
		$location = $model -> getLocations($index);
		$gps -> addLocation($location);
		$transport -> setGpsNavigator($gps);
		return $transport;
	}
	
	private function generateDirections() : array {
		echo "<h1>Generation started.</h1><hr/>";
		$directions = array();
		if (empty($this -> startPointTransport) or empty($this -> endPointTransport)) {
			echo "<h2>Empty...<h2><br/>";
			return array();
		}
		foreach ($this -> startPointTransport as $startTransport) {
			foreach ($this -> endPointTransport as $endTransport) {
				if (
					$startTransport -> getGpsNavigator() -> getId() ==
					$endTransport -> getGpsNavigator() -> getId()
				   ) {
					$direction = new Direction(
						$startTransport, 
						$endTransport
					);
					printObject($direction -> toArray());
					$directions[] = $direction; 
				}
			}	
		}
		return $directions;
	} 
	
	private function groupTransportByGpsNavigator(array &$transport) {
		for ($i = 0; $i < sizeof($transport) - 1; $i++) {
			for ($j = $i + 1; $j < sizeof($transport); $j++) {
				$gpsIdI = $transport[$i] -> getGpsNavigator() -> getId();
				$gpsIdJ = $transport[$j] -> getGpsNavigator() -> getId();
				if ($gpsIdI === $gpsIdJ) {
					$transport[$i] -> addGpsLocations($transport[$j]);
					unset($transport[$j]);
					$transport = array_values($transport);
				}
			}
		}
	}
	
	public function execute(Core $core, TimeLimiter $timeLimiter) : array {
		$this -> startPointTransport = $this -> findTransportByLocationAndTime(
			$core -> getModel(),
			$core -> getStartObject(),
			$timeLimiter
		);
		$this -> endPointTransport = $this -> findTransportByLocationAndTime(
			$core -> getModel(),
			$core -> getEndObject(),
			$timeLimiter
		);
		$this -> groupTransportByGpsNavigator($this -> startPointTransport);
		$this -> groupTransportByGpsNavigator($this -> endPointTransport);
//		printObject($this -> startPointTransport);
//		printObject($this -> endPointTransport);
		return $this -> generateDirections();
	}
	
	private function findTransportByLocationAndTime(DataModel $model,
													MapObject $target, 
													TimeLimiter $timeLimiter) : array {
		$locations = $model -> getLocations();
		$transport = array();
		while ($pair = each($locations)) {
			$index = $pair[0];
			$location = $pair[1];
			if (
				$target -> isContainsLocation($location) and
				$timeLimiter -> isRequiredTime($location -> getTimestamp())
			) {
				$transport[] = $this -> buildTransport($model, $index);
			}			
		}
		return $transport;
	}
	
}