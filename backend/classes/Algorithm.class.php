<?php

abstract class Algorithm extends StrictAccessClass {
	
	const DELAY_TIME = TimeLimiter::MINUTE;
	const MAX_TRAVEL_TIME = TimeLimiter::TEN_MINUTES;
	protected $startPointTransport;
	protected $endPointTransport;
				
	protected function buildTransport(DataModel $model, int $index) : Transport {
		$transport = $model -> getTransport($index);
		$gps = $model -> getGps($index);
		$location = $model -> getLocations($index);
		$gps -> addLocation($location);
		$transport -> setGpsNavigator($gps);
		return $transport;
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
		echo "Start locations found: ";
		echo sizeof($this -> startPointTransport);
		echo ".<br/>";
		echo "End locations found: ";
		echo sizeof($this -> endPointTransport);
		echo ".<br/>";
		echo "<br/>";
		$this -> getIdentifiedLocations();
		$this -> groupTransportByClassLogic($this -> startPointTransport);
		$this -> groupTransportByClassLogic($this -> endPointTransport);
		$this -> filterTransportByDelayTime($this -> startPointTransport, self::DELAY_TIME);
		$this -> filterTransportByDelayTime($this -> endPointTransport, self::DELAY_TIME);
		$this -> sortTransportByFirstLocationTime($this -> startPointTransport);
		$this -> sortTransportByFirstLocationTime($this -> endPointTransport);
		return $this -> generateDirections();
	}
	
	private function getIdentifiedLocations() : string {
		$points1 = $this -> identifiedPointsToArray($this -> startPointTransport);
		$points2 = $this -> identifiedPointsToArray($this -> endPointTransport);
		$points = array_merge($points1, $points2);
		$points = json_encode($points);
		file_put_contents("points.json", $points);
		return $points;
	}
	
	private function identifiedPointsToArray(array $identifiedPoints) : array {
		$pointsArray = array();
		foreach ($identifiedPoints as $transport) {
			$point = array();
			$archive = $transport -> getGpsNavigator() -> getLocationsArchive();
			$lat = $archive[0] -> getLatitude();
			$lng = $archive[0] -> getLongitude();
			$id_gps = $transport -> getGpsNavigator() -> getId();
			$route = $transport -> getRoute();
			$point = array($lat, $lng, $id_gps, $route);
			$pointsArray[] = $point;
		}
		return $pointsArray;
	}
	
	protected function findTransportByLocationAndTime(DataModel $model,
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
	
	protected function filterTransportByDelayTime(array &$transport, int $delayTime) {
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
	
	abstract protected function groupTransportByClassLogic(array &$transport);
	
	protected function rebuildTransport(
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
	
	protected function sortTransportByFirstLocationTime(array &$transport) : array {
		$comparator = function ($a, $b) {
			$a = $a -> getGpsNavigator() -> getAverageLocation() -> getTimestamp();
			$b = $b -> getGpsNavigator() -> getAverageLocation() -> getTimestamp();
			if ($a < $b) {
				return -1;
			} else if ($a > $b) {
				return 1;
			} else {
				return 0;
			}			
		};
		usort($transport, $comparator);
		return $transport;
	}
	
}