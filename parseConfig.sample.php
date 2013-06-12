<?php

class parseConfig{

	protected $_current;
	protected $_apps = array(

		'default' => array(
			'APPID' => '',
			'MASTERKEY' => '',
			'RESTKEY' => '',
			'PARSEURL' => 'https://api.parse.com/1/'
		)

	);

	public function __construct($app){ 
		if(array_key_exists($app, $this->_apps)){
			$this->_current = $this->_apps[$app];
		}
	}

	public function __get($name){
		if(isset($this->_current)){
			return $this->_current[$name];
		}
	}

}

