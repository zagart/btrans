<?php

abstract class Filter extends StrictAccessClass {
	
	public abstract function applyFilters(array $filterable, array $filterConstants);
	
}