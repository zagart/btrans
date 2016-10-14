<?php

class TransportFilter extends Filter {
	
	const BY_TIMESTAMP = 0;
	
	//function breaks object-oriented model and split its elements (Transport objects)
	//after splitting they will be sorted by timestamp
	public function applyFilters(array $transport, array $constants) : array {
		$filteredTransport = array();
		foreach ($constants as $constant) {
			if ($constant === self::BY_TIMESTAMP) {
				$filteredTransport = $this -> filterByTimestamp($transport);
				usort($filteredTransport, array("TransportFilter", "compareByTime"));
				echo("<h1>Filters applied.</h1>");
				debug($transport);
			}
		}
		return $filteredTransport;
	}
	
	private static function compareByTime($a, $b) : int {
		$a = $a -> getGpsNavigator -> getLocationsArchive();
		$a = $a[0] -> getTimestamp();
		$b = $b -> getGpsNavigator -> getLocationsArchive();
		$b = $b[0] -> getTimestamp();
		if ($a == $b) {
	//        echo "a ({$a -> t}) is same priority as b ({$b -> t}), keeping the same<hr/>";
			return 0;
		}
		else if ($a > $b) {
	//        echo "a ({$a -> t}) is higher priority than b ({$b -> t}), moving b down array<hr/>";
			return 1;
		}
		else {
	//        echo "b ({$b -> t}) is higher priority than a ({$a -> t}), moving b up array<hr/>";                
			return -1;
		}
	}
	
	private function filterByTimestamp(array $transport) : array {
		$multipliedTransportArray = array();
		foreach ($transport as $singleTransport) {
			$multipliedTransportArray[] = $this -> multiplyTransportByLocations($singleTransport);
		}
		$splittedMultipliedTransportArray = array();
		foreach ($multipliedTransportArray as $multipliedTransport) {
			foreach ($multipliedTransport as $transport) {
				$splittedMultipliedTransportArray[] = $transport;
			}
		}
		return $splittedMultipliedTransportArray;
	}
	
	private function multiplyTransportByLocations(Transport $transport) : array {
		$multipliedTransport = array();
		$instance = array(
			"id" => $transport -> getId(), 
			"gpsId" => $transport -> getGpsNavigator() -> getId(), 
			"route" => $transport -> getRoute(), 
			"type" => $transport -> getType(),
			"location" => null,
		);
		$locations = $transport -> getGpsNavigator() -> getLocationsArchive();
		foreach ($locations as $location) {
			$newInstance = $instance;
			$newInstance["location"] = $location;
			$multipliedTransport[] = $newInstance;
		}
		return $multipliedTransport;
	}
	
}