<?php

class parseObject extends parseRestClient{
	public $_includes = array();
	protected $_className = '';

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
			$this->data[$name] = $value;
		}
	}

        public function setClassName($className) {
            $this->_className = $className;
        }
        
        public function ACL($acl = null) {
            if($acl)
                $this->data['ACL'] = $acl;
            
            return $this->data['ACL'];
        }

        public function setProperty($name, $value) {
		if($name != '_className'){
			$this->data[$name] = $value;
		}
        }

        public function getProperty($name) {
            return $this->data[$name];
        }
        
	public function save(){
		if(count($this->data) > 0 && $this->_className != ''){
			$request = $this->request(array(
				'method' => 'POST',
				'requestUrl' => 'classes/'.$this->_className,
				'data' => $this->data,
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
				$request['include'] = implode(',', $this->_includes);
			}
			
			return $request;
		}
	}

	public function update($id){
		if($this->_className != '' || !empty($id)){
			$request = $this->request(array(
				'method' => 'PUT',
				'requestUrl' => 'classes/'.$this->_className.'/'.$id,
				'data' => $this->data,
			));

			return $request;
		}
	}

	public function increment($field,$amount){
		$this->data[$field] = $this->dataType('increment', $amount);
	}

	public function decrement($id){
		$this->data[$field] = $this->dataType('decrement', $amount);
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