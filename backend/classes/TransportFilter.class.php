<?php

class TransportFilter extends Filter {
	
	const BY_TIMESTAMP = 0;
	
	public function applyFilters(array &$transport, array $constants) : array {
		foreach ($constants as $constant) {
			if ($constant === BY_TIMESTAMP) {
				return $this -> filterByTimestamp($transport);
			}
		}
		return array();
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
		);
		$locations = $transport -> getGpsNavigator() -> getLocationsArchive();
		foreach ($locations as $location) {
			$newInstance = clone $instance;
			$newInstance["location"] -> $location;
			$multipliedTransport[] = $newInstance;
		}
		return $multipliedTransport;
	}
	
}