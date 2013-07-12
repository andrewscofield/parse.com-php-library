<?php
/*
	// Adding the possibility to run parse cloud code functions
	$cloud = new parseCloud("functionName");
	// Setting the params
	$cloud->__set('action',1234);
	$cloud->__set('identifier',"aZ02fe2a");
	// Running the cloud function
	$result = $cloud->run();
	print_r($result);
*/
class parseCloud extends parseRestClient{
	public $_options;
	private $_functionName = '';

	public function __construct($function=''){
		$this->_options = array();
		if($function != ''){
			$this->_functionName = $function; 
		}
		else{
			$this->throwError('include the functionName when creating a parseCloud');
		}

		parent::__construct();
	}

	public function __set($name,$value){
		$this->_options[$name] = $value;
	}
	public function run(){
		if($this->_functionName != ''){
			$request = $this->request(array(
				'method' => 'POST',
				'requestUrl' => 'functions/'.$this->_functionName,
				'data' => $this->_options,
			));
			return $request;
		}
	}
}

?>