<?php

class IdAlgorithm extends Algorithm {
	
	const DELAY_TIME = 180;
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
		$directions = array();
		if (empty($this -> startPointTransport) or empty($this -> endPointTransport)) {
			return array();
		}
		for ($i = 0; $i < sizeof($this -> startPointTransport); $i++) {
			for ($j = 0; $j < sizeof($this -> endPointTransport); $j++) {
				if (
					$this -> startPointTransport[$i] -> getGpsNavigator() -> getId() ==
					$this -> endPointTransport[$j] -> getGpsNavigator() -> getId()
				   ) {
					$direction = new Direction(
						$this -> startPointTransport[$i], 
						$this -> endPointTransport[$j]
					);
					unset($this -> startPointTransport[$i]);
					unset($this -> endPointTransport[$j]);
					$i > 0 ? $i-- : $i;
					$j > 0 ? $j-- : $j;
					$this -> startPointTransport = array_values($this -> startPointTransport);
					$this -> endPointTransport = array_values($this -> endPointTransport);
					$directions[] = $direction; 

				}		
			}
		}
		return $directions;
	} 
	
	private function rebuildTransport(
		Transport $transport,
		array $splittedLocations
	) : array {
		$transportByLocationsGroup = array();
		foreach ($splittedLocations as $locationsGroup) {
			$gps = new GPSNavigator($transport -> getGpsNavigator() -> getId());
			$gps -> addAllLocations($locationsGroup);
			$transport = new Transport(
				$transport -> getRoute(),
				$transport -> getType()
			);
			$transport -> setGpsNavigator($gps);
			$transportByLocationsGroup[] = $transport;
		}
		return $transportByLocationsGroup;
	}
	
	private function filterTransportByDelayTime(array &$transport, int $delayTime) {
		$filteredTransport = array();
		for ($i = 0; $i < sizeof($transport); $i++) {
			$initialTime = $transport[$i] -> getGpsNavigator() -> getLocationsArchive()[0] -> getTimestamp();
			$route = $transport[$i] -> getRoute();
			$locations = $transport[$i] -> getGpsNavigator() -> getLocationsArchive();
			$splittedLocations = Location::splitLocationsByDelayTime($locations, $delayTime);
			foreach ($this -> rebuildTransport($transport[$i], $splittedLocations) as $unit) {
				$filteredTransport[] = $unit;
			}
			unset($transport[$i]);
			$transport = array_values($transport);
			$i--;
		}
		foreach ($filteredTransport as $unit) {
			$transport[] = $unit;
		}
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
		echo sizeof($this -> startPointTransport);
		echo "<br/>";
		echo sizeof($this -> endPointTransport);
		$this -> groupTransportByGpsNavigator($this -> startPointTransport);
		$this -> groupTransportByGpsNavigator($this -> endPointTransport);
		$this -> filterTransportByDelayTime($this -> startPointTransport, self::DELAY_TIME);
		$this -> filterTransportByDelayTime($this -> endPointTransport, self::DELAY_TIME);
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