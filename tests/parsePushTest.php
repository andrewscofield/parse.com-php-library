<?php
class parsePushTest extends \Enhance\TestFixture {

	public function setUp(){
	}

	public function sendWithGlobalMessageExpectTrue(){
		$parsePush = \Enhance\Core::getCodeCoverageWrapper('parsePush', array( 'Global message to be sent out right away' ));
		$return = $parsePush->send();
				
		\Enhance\Assert::isTrue( $return );
	}

	public function deleteWithUrlExpectEmpty(){
		$parsePush = \Enhance\Core::getCodeCoverageWrapper('parsePush');

		$parsePush->channels = array('TEST_CHANNEL_ONE','TEST_CHANNEL_TWO');
		$parsePush->expiration_time = time( strtotime('+3 days') ); //expire 3 day from now
		//$parsePush->expiration_time_interval = 86400; //expire in 24 hours from now
		$parsePush->type = 'ios';
		$parsePush->data = array(
			'alert' => 'Testing Channel 1',
			'badge' => 538, //ios only
			'sound' => 'cheer', //ios only
			'content-available' => 1, //ios only - for newsstand applications
			//'title' => 'test notification title' //android only
			'custom-data' => 'This data will be accessible in the ios and android SDK callback for push notifications'
		);

		$return = $parsePush->send();

		\Enhance\Assert::isTrue( $return );
	}

}

?>