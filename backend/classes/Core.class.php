<?php

class Core extends StrictAccessClass {
	
	const DEFAULT_DATA_PATH = DIRECTORY_SEPARATOR."backend"
		.DIRECTORY_SEPARATOR."resources"
		.DIRECTORY_SEPARATOR;
	
	const OBJECT_TYPE_ROUND = 0;
	const OBJECT_TYPE_POLYGON = 1;
	
	private $data = array();
	private $model = null;
	private $startObject = null;
	private $endObject = null;
	
	public function __construct() {
		$this -> model = new DataModel();
	}
	
	public function convertData() {
		if (!empty($this -> data)) {
			$this -> model -> parseData($this -> data);
			unset($this -> data);
		} else {
			throw new InvalidOperationException("There is no data for convert. Load data first");
		}
	}

	public function loadData(string $fileName, 
					  string $path = self::DEFAULT_DATA_PATH) {
		$file = file_get_contents($_SERVER['DOCUMENT_ROOT'].$path.$fileName);
		if ($file) {
			$this -> data = json_decode($file);
		} 
	}
	
	public function process(Algorithm $logic) {
		$logic -> execute($this -> $model);
	}
	
	private function setRoundObjects(MapRound $startObject, 
									 MapRound $endObject) {
		$this -> startObject = $startObject;
		$this -> endObject = $endObject;
		return true;
	}
	
	private function setPolygonObjects(MapPolygon $startObject, 
									   MapPolygon $endObject) {
		throw new Exception("Data type not released");
	}
	
	public function setUpInitialData(MapObject $startObject, 
					 MapObject $endObject, 
					 int $dataType = self::OBJECT_TYPE_ROUND) {
		switch ($dataType) {
			case self::OBJECT_TYPE_ROUND:
				$this -> setRoundObjects($startObject, $endObject);
				break;
			case self::OBJECT_TYPE_POLYGON:
				$this -> setPolygonObjects($startObject, $endObject);
				break;
			default:
				throw new IllegalArgumentException("Data type not found");
		}	
	}
	
	
}