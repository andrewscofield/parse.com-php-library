<?php
class parseObjectTest extends \Enhance\TestFixture {
	
	private $parseObject;

	public function setUp(){
		//$this->parseObject = new parseObject('test');
		$this->parseObject = \Enhance\Core::getCodeCoverageWrapper('parseObject', array('test'));
		$this->testfield1 = 'test1';
		$this->testfield2 = 'test2';
	}

	public function saveWithTestfield1ExpectObjectId(){
		$parseObject = $this->parseObject;
		$parseObject->testfield1 = $this->testfield1;
		$return = $parseObject->save();

		\Enhance\Assert::isTrue( property_exists($return,'objectId') );
	}

	public function getWithObjectIdExpectTest1(){
		$parseObject->testfield2 = $this->testfield2;
		$save = $parseObject->save();

		$return = $parseObject->get($save->objectId);

		\Enhance\Assert::areIdentical('test2', $return->testfield2);
	}
	
	public function deleteWithObjectIdExpectEmpty(){
		$parseObject->testfield1 = $this->testfield2;
		$save = $parseObject->save();

		$return = $parseObject->delete($save->objectId);
		
		\Enhance\Assert::isTrue( $return );
	}

}

?>