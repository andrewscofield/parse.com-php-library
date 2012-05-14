<?php

class parseFile extends parseRestClient{

	private $_fileName;
	private $_contentType;

	public function __construct($contentType,$data){
		if($contentType != '' && $data !=''){
			$this->_contentType = $contentType;
			$this->_data = $data;
		}
		else{
			$this->throwError('When creating a parseFile object you must set the content-type and data');
		}
		
		parent::__construct();

	}

	public function save($fileName){
		if($fileName != '' && $this->_contentType != '' && $this->_data != ''){
			$request = $this->request(array(
				'method' => 'POST',
				'requestUrl' => 'files/'.$fileName,
				'contentType' => $this->_contentType,
				'data' => $this->_data,
			));
			return $request;
		}
		else{
			$this->throwError('Please make sure you are passing a proper filename as string (e.g. hello.txt)');
		}
	}

	public function delete($parseFileName){
		if($parseFileName != ''){
			$request = $this->request(array(
				'method' => 'DELETE',
				'requestUrl' => 'files/'.$parseFileName,
				'contentType' => $this->_contentType,
			));
			return $request;

		}
	}



}

?>