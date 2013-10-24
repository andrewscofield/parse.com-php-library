<?php
class parseObjectTest extends \Enhance\TestFixture {
	
	private $parseObject;
	private $parseConfig;

	public function setUp(){
		$this->parseConfig = new parseConfig;
		$this->parseObject = \Enhance\Core::getCodeCoverageWrapper('Parse\Object', array($this->parseConfig,'test'));
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
		$parseObject = $this->parseObject;
		$parseObject->testfield2 = $this->testfield2;
		$save = $parseObject->save();

		$return = $parseObject->get($save->objectId);

		\Enhance\Assert::areIdentical('test2', $return->testfield2);
	}
	
	public function updateWithObjectIdExpectupdatedAt(){
		$parseObject = $this->parseObject;
		$parseObject->testfield2 = $this->testfield2;
		$save = $parseObject->save();

		$updateObject = new Parse\Object($this->parseConfig, 'test');
		$updateObject->testfield2 = 'updated test2';
		$return = $parseObject->update($save->objectId);

		\Enhance\Assert::isTrue( property_exists($return, 'updatedAt') );
	}
	
	public function deleteWithObjectIdExpectEmpty(){
		$parseObject = $this->parseObject;
		$parseObject->testfield1 = $this->testfield2;
		$save = $parseObject->save();

		$return = $parseObject->delete($save->objectId);
		
		\Enhance\Assert::isTrue( $return );
	}

}

?>