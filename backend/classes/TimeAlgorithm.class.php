<?php

class TimeAlgorithm extends Algorithm {
	
//	const DELAY_TIME = 180;
//	protected $startPointTransport;
//	protected $endPointTransport;
	
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
		$this -> groupTransportByClassLogic($this -> startPointTransport);
		$this -> groupTransportByClassLogic($this -> endPointTransport);
		return $this -> generateDirections();
	}
	
	protected function generateDirections() : array {
		$directions = array();
		if (empty($this -> startPointTransport) or empty($this -> endPointTransport)) {
			return $directions;
		}
		$directionsSize = 0;
		if (sizeof($this -> startPointTransport) < sizeof($this -> endPointTransport)) {
			$directionsSize = sizeof($this -> startPointTransport);
		} else {
			$directionsSize = sizeof($this -> endPointTransport);
		}
		for ($i = 0; $i < $directionsSize; $i++) {
					$direction = new Direction(
						$this -> startPointTransport[$i], 
						$this -> endPointTransport[$i]
					);
					$directions[] = $direction; 	
		}
		return $directions;
	} 

	//time specific grouping
	protected function groupTransportByClassLogic(array &$transport) {
		$filter = new TransportFilter();
		$criterions = array();
		$criterions[] = TransportFilter::BY_TIMESTAMP;
		$transport = $filter -> applyFilters($transport, $criterions);
		for ($i = 0; $i < sizeof($transport) - 1; $i++) {
			for ($j = 0; $j < sizeof($transport) - 1; $j++) {
				$idI = $transport[$i] -> getId();
				$idJ = $transport[$j] -> getId();
				$timestampI = $transport[$i] -> getTimestamp();
				$timestampJ = $transport[$j] -> getTimestamp();
				if ($idI === $idJ) {
					if ($idI === $idJ && 
						($timestampJ > $timestampI && $timestampJ < $timestampI + self::DELAY_TIME)) {
						unset($transport[$j]);
						array_values($transport);
					}
				}
			}
		}
		debug($transport);
	}
	
}