<?php
class parseFileTest extends \Enhance\TestFixture {

	public function setUp(){
		
	}

	public function saveExpectName(){
		$return = \Enhance\Core::getCodeCoverageWrapper('parseFile', array('text/plain','Working at Parse is great!'));
		$save = $return->save('hello.txt');

		\Enhance\Assert::isTrue( property_exists($save,'name') );
	}

	public function deleteWithUrlExpectTrue(){
		$file = new parseFile('text/plain','Working at Parse is great!');
		$save = $file->save('hello.txt');

		//SET BOTH ARGUMENTS BELOW TO FALSE, SINCE WE ARE DELETING A FILE, NOT SAVING ONE
		$todelete = new parseFile;
		$return = $todelete->delete($save->name);
		
		\Enhance\Assert::isTrue( $return );
	}

}

?>