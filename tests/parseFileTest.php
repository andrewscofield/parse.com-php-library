<?php
class parseFileTest extends \Enhance\TestFixture {

	public function setUp(){
		
	}

	public function saveExpectName(){
		$return = \Enhance\Core::getCodeCoverageWrapper('parseFile', array('test.txt','Working at Parse is great!'));

		\Enhance\Assert::isTrue( property_exists($return,'name') );
	}

	public function deleteWithUrlExpectTrue(){
		$file = new parseFile('test.txt','Working at Parse is great!');

		$todelete = new parseFile();		
		$return = $todelete->delete($file->name);
		
		\Enhance\Assert::isTrue( $return );
	}

}

?>