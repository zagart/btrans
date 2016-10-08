<?php

class IdAlgorithm extends Algorithm {
	
	protected function generateDirections() : array {
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

	//id specific grouping
	protected function groupTransportByClassLogic(array &$transport) {
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
	
}