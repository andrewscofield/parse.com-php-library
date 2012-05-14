<?php
class parsePushTest extends \Enhance\TestFixture {

	public function setUp(){
	}

	public function sendWithGlobalMessageExpectTrue(){
		$parsePush = \Enhance\Core::getCodeCoverageWrapper('parsePush', array( 'Global message to be sent out right away' ));
		$return = $parsePush->send();
				
		\Enhance\Assert::isTrue( $return );
	}

	public function sendWithDataExpectTrue(){
		$parsePush = \Enhance\Core::getCodeCoverageWrapper('parsePush');

		//$parsePush->channel = 'TEST_CHANNEL_ONE'; //this or channels required
		$parsePush->channels = array('TEST_CHANNEL_ONE','TEST_CHANNEL_TWO'); //this or just channel required
		$parsePush->alert = 'Testing Channel 1'; //required

		//BELOW SETTINGS ARE OPTIONAL, LOOKUP REST API DOCS HERE: http://parse.com/docs/rest#push FOR MORE INFO
		$parsePush->expiration_time = time( strtotime('+3 days') ); //expire 3 day from now
		//$parsePush->expiration_time_interval = 86400; //expire in 24 hours from now
		$parsePush->type = 'ios';
		$parsePush->badge = 538; //ios only
		$parsePush->sound = 'cheer'; //ios only
		$parsePush->content_available = 1; //ios only - for newsstand applications. Also, changed from content-available to content_available. 
		//$parsePush->title = 'test notification title'; //android only - gives title to the notification

		//CUSTOM DATA CAN BE SENT VERY EASILY ALONG WITH YOUR NOTIFICATION MESSAGE AND CAN BE ACCESSED PROGRAMATICALLY VIA THE MOBILE DEVICE... JUST DON'T SET NAMES THE SAME AS RESERVERD ONES MENTIONED ABOVE
		$parsePush->customData = 'This data will be accessible in the ios and android SDK callback for push notifications';

		$return = $parsePush->send();

		\Enhance\Assert::isTrue( $return );
	}

}

?>