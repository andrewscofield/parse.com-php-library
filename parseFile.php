<?php

class parseFile extends parseRestClient{

	private $_fileName;
	private $_data;

	public function __construct($fileName='',$data=''){
		if($filename != '' && $data !=''){
			$this->_fileName = $fileName;
			$this->_data = $data;
		}
		
		parent::__construct();

	}

	public function save(){
		if($this->_filename != '' && !$this->_data != ''){
			$request = $this->request(array(
				'type' => 'files',
				'method' => 'POST',
				'requestUrl' => 'files/'.$this->_fileName,
				'data' => $this->_data,
			));
			return $request;

		}
	}


}

?>