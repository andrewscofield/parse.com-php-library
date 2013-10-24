<?php
namespace Parse;

class GeoPoint extends RestClient
{

	public $lat;
	public $long;
	public $location;
	
	public function __construct($parseConfig = null,$lat,$long){
		$this->lat = $lat;
		$this->long = $long;
		$this->location = $this->dataType('geopoint', array($this->lat, $this->long));
		parent::__construct($parseConfig);
	}

	public function __toString(){		
		return json_encode($this->location);

	}
	
	public function get(){		
		return json_encode($this->location);

	}	

}

?>
