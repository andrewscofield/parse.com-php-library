<?php

class parseObject extends parseRestClient{
	public $_includes = array();
	private $_className = '';

	public function __construct($class=''){
		if($class != ''){
			$this->_className = $class;
		}
		else{
			$this->throwError('include the className when creating a parseObject');
		}

		parent::__construct();
	}

	public function __set($name,$value){
		if($name != '_className'){
			$this->_data[$name] = $value;
		}
	}

	public function save(){
		if(count($this->_data) > 0 && $this->_className != ''){
			$request = $this->request(array(
				'method' => 'POST',
				'requestUrl' => 'classes/'.$this->_className,
				'data' => $this->_data,
			));
			return $request;
		}
	}

	public function get($id){
		if($this->_className != '' || !empty($id)){
			$request = $this->request(array(
				'method' => 'GET',
				'requestUrl' => 'classes/'.$this->_className.'/'.$id
			));
			
			if(!empty($this->_includes)){
				$request['include'] = implode(',', $this->_order);
			}
			
			return $request;
		}
	}
	
	public function delete($id){
		if($this->_className != '' || !empty($id)){
			$request = $this->request(array(
				'method' => 'DELETE',
				'requestUrl' => 'classes/'.$this->_className.'/'.$id
			));

			return $request;
		}		
	}
	
	public function addInclude($name){
		$this->_includes[] = $name;
	}
}

?>