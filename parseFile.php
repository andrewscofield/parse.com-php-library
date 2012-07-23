<?php

class parseFile extends parseRestClient{

	private $_fileName;
	private $_contentType;

	public function __construct($contentType='',$data=''){
		if($contentType != '' && $data !=''){
			$this->_contentType = $contentType;
			$this->data = $data;
		}
		
		parent::__construct();

	}

	public function save($fileName){
		if($fileName != '' && $this->_contentType != '' && $this->data != ''){
			$request = $this->request(array(
				'method' => 'POST',
				'requestUrl' => 'files/'.$fileName,
				'contentType' => $this->_contentType,
				'data' => $this->data,
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