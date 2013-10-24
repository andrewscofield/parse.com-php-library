<?php

class parseFileTest extends \Enhance\TestFixture {

	private $parseConfig;

	public function setUp(){
		$this->parseConfig = new parseConfig;
	}

	public function saveExpectName(){
		$return = \Enhance\Core::getCodeCoverageWrapper(
			'Parse\File', array($this->parseConfig, 'text/plain','Working at Parse is great!')
		);
		$save = $return->save('hello.txt');

		\Enhance\Assert::isTrue( property_exists($save,'name') );
	}

	public function deleteWithUrlExpectTrue(){
		$file = new Parse\File($this->parseConfig, 'text/plain','Working at Parse is great!');
		$save = $file->save('hello.txt');

		//SET BOTH ARGUMENTS BELOW TO FALSE, SINCE WE ARE DELETING A FILE, NOT SAVING ONE
		$todelete = new Parse\File($this->parseConfig);
		$return = $todelete->delete($save->name);
		\Enhance\Assert::isTrue( $return );
	}

}

?>