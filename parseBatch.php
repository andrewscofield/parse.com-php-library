<?php
include_once 'parse.php';
include_once 'parseObject.php';
/*
 *	Example Usage:
       //NOTES: In Parse.com, create "TestBatch" class, then 1 column names "Notes", and 2 rows.
       //Get the objectId from each row and insert into the code below
  		$b = new parseBatch();
 		$b->add_update_request('TestBatch', 'INSERT_ID', array('Notes'=>'Custom Note: '.$csv_file_location.'.Update via API on PHP Server Time Seconds: '.time()));
 		$b->add_update_request('TestBatch', 'INSERT_ID', array('Notes'=>'Custom Note: '.$csv_file_location.'.Second Record Update via API on PHP Server Time Seconds: '.time()));
 		$results = $b->batch_request();
*/
class parseBatch extends parseObject{

	public function __construct(){
		//API VERSION IS REQUIRED
		if(!defined('PARSE_API_VERSION')){
			define('PARSE_API_VERSION', '1');
		}
		//batch is the class name for batch updates
		$this->_className = 'batch';
		$this->data = array('requests'=>array());
		parent::__construct('batch');
	}

	public function batch_request(){
		$requestBatch = array(
			'method' => 'POST',
			'requestUrl' => 'batch',
			'data' => $this->data,
		);
		$request = $this->request($requestBatch);
		return $request;
	}

	public function add_request($method, $path, $body){
		if(!is_array($body) && $method != 'DELETE'){
			return array('error'=>'body is not properly formatted as an array');
		}
		elseif(count($this->data['requests']) >= 50){
			return array('error'=>'limit exceeded, batch requests limited to 50 requests');
		}
		elseif($method == 'DELETE') {
			$this->data['requests'][] = array('method'=>$method, 'path'=>$path);
			return true;
		}
		else {
			$this->data['requests'][] = array('method'=>$method, 'path'=>$path, 'body'=>$body);
			return true;
		}
	}

	public function add_update_request($class, $objId, $data){
		$this->add_request('PUT', '/'.PARSE_API_VERSION.'/classes/'.$class.'/'.$objId, $data);
	}

	public function add_create_request($class, $data){
		$this->add_request('POST', '/'.PARSE_API_VERSION.'/classes/'.$class,$data);
	}

	public function add_delete_request($class, $objId){
		$this->add_request('DELETE', '/'.PARSE_API_VERSION.'/classes/'.$class.'/'.$objId, array());
	}

}