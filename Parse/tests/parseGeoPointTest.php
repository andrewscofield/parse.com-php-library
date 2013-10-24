<?php
class parseGeoPointTest extends \Enhance\TestFixture {
	private $parseConfig;

	public function setUp(){
		$this->parseConfig = new parseConfig;
	}

	public function getGeoPointExpectType(){
		$return = \Enhance\Core::getCodeCoverageWrapper('Parse\GeoPoint', array($this->parseConfig, 40.0,-30.0));

		\Enhance\Assert::isTrue( array_key_exists('__type',$return->location) );
	}

}

?>