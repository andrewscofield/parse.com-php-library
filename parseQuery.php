<?php

class parseQuery extends parseRestClient{
	private $_limit = 100;
	private $_skip = 0;
	private $_order = array();
	private $_query = array();

	public function __construct($class=''){
		if($class == 'users'){
			$this->_requestUrl = $class;
		}
		elseif($class != ''){
			$this->_requestUrl = 'classes/'.$class;
		}
		else{
			$this->throwError('include the className when creating a parseQuery');
		}
		
		parent::__construct();

	}

	public function find(){
		$request = $this->request(array(
    		'method' => 'GET',
    		'requestUrl' => $this->_className,
    		'urlParams' => array(
    			'query' => json_encode( $this->_query ),
    			'order' => implode(',',$this->_order),
    			'limit' => $this->_limit,
    			'skip' => $this->_skip,
    			'include' => implode(',',$this->_include)
    		),
		));
		
    	return $request;
	}

	public function setLimit($int){
		if ($int > 1 && $int < 1000){
			$this->_limit = $int;
		}
		else{
			$this->throwError('parse requires the limit parameter be between 1 and 1000');
		}
	}

	public function orderByAscending($value){
		if(is_string($value)){
			$this->_order[] = $value;
		}
		else{
			$this->throwError('the order parameter on a query must be a string');
		}
	}

	public function orderByDescending($value){
		if(is_string($value)){
			$this->_order[] = '-'.$value;
		}
		else{
			$this->throwError('the order parameter on parseQuery must be a string');
		}
	}
	
	public function whereInclude($value){
		if(is_string($value)){
			$this->_include[] = $value;
		}
		else{
			$this->throwError('the include parameter on parseQuery must be a string');
		}
	}

	public function where($key,$value){
		$this->whereEqualTo($key,$value);
	}

	public function whereEqualTo($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = $value;
		}
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
	}

	public function whereNotEqualTo($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$ne' => $value
			);
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
	}

	public function whereGreaterThan($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$gt' => $value
			);
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
	
	}

	public function whereLessThan($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$lt' => $value
			);
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
	
	}

	public function whereGreaterThanOrEqualTo($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$gte' => $value
			);
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
	
	}

	public function whereLessThanOrEqualTo($key,$value){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$lte' => $value
			);
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
	
	}

	public function whereContainedIn($key,$value){
		if(isset($key) && isset($value)){
			if(is_array($value)){
				$this->_query[$key] = array(
					'$in' => $value
				);		
			}
			else{
				$this->throwError('$value must be an array to check through');		
			}
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
	
	}

	public function whereNotContainedIn($key,$value){
		if(isset($key) && isset($value)){
			if(is_array($value)){
				$this->_query[$key] = array(
					'$nin' => $value
				);		
			}
			else{
				$this->throwError('$value must be an array to check through');		
			}
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
	
	}

	public function whereExists($key){
		if(isset($key)){
			$this->_query[$key] = array(
				'$exists' => true
			);
		}
	}

	public function whereDoesNotExist($key){
		if(isset($key)){
			$this->_query[$key] = array(
				'$exists' => false
			);
		}
	}
	
	public function whereRegex($key,$value,$options=''){
		if(isset($key) && isset($value)){
			$this->_query[$key] = array(
				'$regex' => $value,
				'options' => $options
			);
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
		
	}

	public function wherePointer($key,$className,$objectId){
		if(isset($key) && isset($className)){
			$this->_query[$key] = $this->dataType('pointer', array($className,$objectId));
		}	
		else{
			$this->throwError('the $key and $className parameters must be set when setting a "where" pointer query method');		
		}
		
	}

	public function whereInQuery($key,$className,$inQuery){
		if(isset($key) && isset($className)){
			$this->_query[$key] = array(
				'$inQuery' => json_encode($inQuery),
				'className' => $className
			);
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
		
	}

	public function whereNotInQuery($key,$className,$inQuery){
		if(isset($key) && isset($className)){
			$this->_query[$key] = array(
				'$notInQuery' => json_encode($inQuery),
				'className' => $className
			);
		}	
		else{
			$this->throwError('the $key and $value parameters must be set when setting a "where" query method');		
		}
		
	}
}

?>