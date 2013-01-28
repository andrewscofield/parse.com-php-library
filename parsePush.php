<?php

class parsePush extends parseRestClient{

	public $channels;
	public $channel;
	public $expiration_time;
	public $expiration_time_intreval;
	public $content_available;
	public $type;
	public $title;

	private $_globalMsg;

	public function __construct($globalMsg=''){
		if($globalMsg != ''){
			$this->_globalMsg = $globalMsg;
		}
		
		parent::__construct();

	}
	
	public function __set($name,$value){
		if($name != 'channel' || $name != 'channels' || $name != 'expiration_time' || $name != 'expiration_interval' || $name != 'type' || $name != 'data'){
			$this->data[$name] = $value;
		}
	}

	public function send(){
		if($this->_globalMsg != ''){
			$request = $this->request(array(
				'method' => 'POST',
				'requestUrl' => 'push',
				'data' => array(
					'channel' => '',
					'data' => array(
						'alert' => $this->_globalMsg
					)
				),
			));
			return $request;

		}
		else{
			if(count($this->data) > 0){
				if($this->channel == '' && empty($this->channels)){
					$this->throwError('No push channel has been set');
				}
				$params = array(
					'method' => 'POST',
					'requestUrl' => 'push',
					'data' => array(
						'data' => $this->data
					)
				);
				
				if(!empty($this->channels)){
					$params['data']['channels'] = $this->channels;
				}
				if(!empty($this->channel)){
					$params['data']['channel'] = $this->channel;
				}
				if(!empty($this->expiration_time)){
					$params['data']['expiration_time'] = $this->expiration_time;
				}
				if(!empty($this->expiration_time_interval)){
					$params['data']['expiration_interval'] = $this->expiration_interval;
				}
				if(!empty($this->content_available)){
					//changed back to content-available... underscores are much easier to deal with in PHP
					$params['data']['content-available'] = $this->content_available;
				}
				if(!empty($this->type)){
					$params['data']['type'] = $this->type;
				}
				
				$request = $this->request($params);
				return $request;

			}
			else{
				$this->throwError('No push data has been set, you must set at least data. Please see the docs. ');
			}
		}
	}
}

?>