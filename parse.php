<?php
include 'parseConfig.php';
include 'parseObject.php';
include 'parseQuery.php';
include 'parseUser.php';
include 'parseFile.php';
include 'parseGeoPoint.php';

class parseRestClient{

	private $_appid = '';
	private $_masterkey = '';
	private $_restkey = '';
	private $_parseurl = '';
	
	public $_data = array();
	public $_requestUrl = '';

	public function __construct(){
		$parseConfig = new parseConfig;
		$this->_appid = $parseConfig::APPID;
    	$this->_masterkey = $parseConfig::MASTERKEY;
    	$this->_restkey = $parseConfig::RESTKEY;
    	$this->_parseurl = $parseConfig::PARSEURL;

		if(empty($this->_appid) || empty($this->_restkey) || empty($this->_masterkey)){
			$this->throwError('You must set your Application ID, Master Key and REST API Key');
		}
	}

	/*
	 * All requests go through this function
	 * 
	 * 
	 */	
	public function request($args){
		$c = curl_init();
		curl_setopt($c, CURLOPT_TIMEOUT, 5);
		curl_setopt($c, CURLOPT_USERAGENT, 'parseRestClient/2.0');
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLINFO_HEADER_OUT, true);
		if(substr(($args['requestUrl'],0,5) == 'files'){
			
		}
		curl_setopt($c, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'X-Parse-Application-Id: '.$this->_appid,
			'X-Parse-REST-API-Key: '.$this->_restkey
		));
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, $args['method']);
		$url = $this->_parseurl . $args['requestUrl'];
		
		if($args['method'] == 'PUT' || $args['method'] == 'POST'){
			$postData = json_encode($args['object']);
			curl_setopt($c, CURLOPT_POSTFIELDS, $postData );
		}
		if(array_key_exists('urlParams',$args)){
			$urlParams = http_build_query($args['urlParams'], '', '&');
    		$url = $url.'?'.$urlParams;
		}

		curl_setopt($c, CURLOPT_URL, $url);
		
		$response = curl_exec($c);
		$responseCode = curl_getinfo($c, CURLINFO_HTTP_CODE);

		$expectedCode = '200';
		if($args['method'] == 'POST'){
			$expectedCode = '201';
		}

		return $this->checkResponse($response,$responseCode,$expectedCode);
	}
	
	public function create($args){
		$params = array(
			'url' => $args['className'],
			'method' => 'POST',
			'object' => $args['object']
		);

		return $this->request($params);
	}	

/*
 * Used to retrieve a parse.com object  
 * 
 * @param array $args - argument hash:
 * 
 * className: string of className
 * objectId: (optional) the objectId of the object you want to update. If none, will return multiple objects from className
 * 
 * @return string $return
 * 
 */
	public function retrieve($args){
		$params = array(
			'url' => $args['className'].'/'.$args['objectId'],
			'method' => 'GET'
		);
		
		return $this->request($params);
	}

/*
 * Used to update a parse.com object  
 * 
 * @param array $args - argument hash:
 * 
 * className: string of className
 * objectId: the objectId of the object you want to update
 * object: object to update in place of old one  
 * 
 * @return string $return
 * 
 */
	public function update($args){
		$params = array(
			'url' => $args['className'].'/'.$args['objectId'],
			'method' => 'PUT',
			'object' => $args['object']
		);
		
		return $this->request($params);
	}

/*
 * Used to query parse.com.  
 * 
 * @param array $args - argument hash:
 * 
 * className: string of className
 * query: array containing query. See: https://www.parse.com/docs/rest#data-querying 
 * order: (optional) used to sort by the field name. use a minus (-) before field name to reverse sort
 * limit: (optional) limit number of results
 * skip:  (optional) used to paginate results
 * 
 * @return string $return
 * 
 */

	public function query($args){
		$params = array(
			'url' => $args['className'],
			'method' => 'GET'
		);
		
		return $this->request(array_merge($params,$args));
	}

/*
 * Used to delete a parse.com object  
 * 
 * @param array $args - argument hash:
 * 
 * className: string of className
 * objectId: (optional) the objectId of the object you want to update. If none, will return multiple objects from className
 * 
 * @return string $return
 * 
 */
	public function delete($args){
		$params = array(
			'url' => $args['className'].'/'.$args['objectId'],
			'method' => 'DELETE'
		);
		
		return $this->request($params);
	}	



	public function dataType($type,$params){
		if($type != ''){
			switch($type){
				case 'date':
					$return = array(
						"__type" => "Date",
						"iso" => date("c", strtotime($params))
					);
					break;
				case 'bytes':
					$return = array(
						"__type" => "Bytes",
						"base64" => base64_encode($params)
					);			
					break;
				case 'pointer':
					$return = array(
						"__type" => "Pointer",
						"className" => $params[0],
						"objectId" => $params[1]
					);			
					break;
				case 'geopoint':
					$return = array(
						"__type" => "GeoPoint",
						"latitude" => floatval($params[0]),
						"longitude" => floatval($params[1])
					);			
					break;
				default:
					$return = false;
					break;	
			}
			
			return $return;
		}	
	}

/*
 * Checks for correct/expected response code.
 * 
 * @param array $return, string $code 
 * 
 * @return string $return['response]
 * 
 */
	private function checkResponse($response,$responseCode,$expectedCode){
		//TODO: Need to also check for response for a correct result from parse.com
		if($responseCode != $expectedCode){
			$error = json_decode($response);
			$this->throwError('ERROR: response code was '.$responseCode.' with message: '.$error->error);
		}
		else{
			//check for empty return
			if($response == '{}'){
				return true;
			}
			else{
				return json_decode($response);
			}
		}
	}
	
	private function throwError($msg,$code=''){
		die($msg.' '.$code);
	}
}


?>