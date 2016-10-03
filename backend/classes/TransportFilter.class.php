<?php

class TransportFilter extends Filter {
	
	const BY_DELAY_TIME = 0;
	
	public function applyFilters(array &$transport, array $constants) {
		foreach ($constants as $constant) {
			if ($constant === BY_DELAY_TIME) {
				filterByDelayTime($transport);
			}
		}
	}
	
	private function filterByDelayTime(array &$transport) {
		//do something
	}
	
}