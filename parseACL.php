<?php
/* 
// example: 
$object = new parseObject();
$object->__set('hello','world');

// This instantiates a ACL object with NO rights! 
$acl = new parseACL();
$acl->setPublicReadAccess(false);
$acl->setReadAccessForId('user_id',true);
$acl->setWriteAccessForRole('role_name',true);

$object->ACL($acl);
$object->save();
*/
class parseACL{
	public $acl;
	public function __construct(){
		$this->acl = new stdClass();
	}
	private function setAccessForKey($access,$key,$bool){
		if(!($access == 'read' || $access == 'write')) return;
		if(is_object($this->acl)) $this->acl = array();
		if($bool) $this->acl[$key][$access] = true;
		else {
			if(isset($this->acl[$key])){ 
				unset($this->acl[$key][$access]);
				if(sizeof($this->acl[$key]) == 0) unset($this->acl[$key]);
			}
			if(sizeof($this->acl) == 0) $this->acl = new stdClass();
		}
	}
	public function setPublicReadAccess($bool){
		$this->setAccessForKey('read','*',$bool);
	}
	public function setPublicWriteAccess($bool){
		$this->setAccessForKey('write','*',$bool);
	}
	public function setReadAccessForId($userId,$bool){
		$this->setAccessForKey('read',$userId,$bool);
	}
	public function setWriteAccessForId($userId,$bool){
		$this->setAccessForKey('write',$userId,$bool);
	}
	public function setReadAccessForRole($role,$bool){
		$this->setAccessForKey('read','role:'.$role,$bool);
	}
	public function setWriteAccessForRole($role,$bool){
		$this->setAccessForKey('write','role:'.$role,$bool);
	}
}
?>