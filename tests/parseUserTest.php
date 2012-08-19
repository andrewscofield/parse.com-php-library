<?php
class parseUserTest extends \Enhance\TestFixture {
	
	public $parseUser;
	public $testUser;
	
	public function setUp(){
		$this->parseUser = new parseUser;
		$this->testUser = array(
			'username' => 'testUser'.rand(),
			'password' => 'testPass',
			'email' => 'testUser@parse.com',
			'customField' => 'customValue'
		);
		
	}

	public function signupWithTestuserExpectObjectId(){
		$parseUser = $this->parseUser;

		$return = $parseUser->signup($this->testUser['username'], $this->testUser['password']);

		//print_r($return);

		$deleteUser = new parseUser;
		$deleteUser->delete($return->objectId,$return->sessionToken);

		\Enhance\Assert::isTrue( property_exists($return,'objectId') );

	}

	public function signupWithEmailAndCustomFieldExpectObjectId(){
		$parseUser = $this->parseUser;
		$parseUser->username = $this->testUser['username'];
		$parseUser->password = $this->testUser['password'];
		$parseUser->email = $this->testUser['email'];
		$parseUser->customField = $this->testUser['customField'];

		$return = $parseUser->signup();

		$deleteUser = new parseUser;
		$deleteUser->delete((string)$return->objectId,(string)$return->sessionToken);

		\Enhance\Assert::isTrue( property_exists($return,'objectId') );
		
	}

	public function loginWithUsernameAndPasswordExpectObjectId(){
		$parseUser = $this->parseUser;
		$parseUser->username = $this->testUser['username'];
		$parseUser->password = $this->testUser['password'];

		$return = $parseUser->signup();

		$loginUser = new parseUser;
		$loginUser->username = $this->testUser['username'];
		$loginUser->password = $this->testUser['password'];

		$returnLogin = $loginUser->login();
	
		$deleteUser = new parseUser;
		$deleteUser->delete((string)$return->objectId,(string)$return->sessionToken);

		\Enhance\Assert::isTrue( property_exists($returnLogin,'objectId') );
	}

	public function getUserWithObjectIdExpectUsername(){
		$testUser = new parseUser;
		$testUser->username = $this->testUser['username'];
		$testUser->password = $this->testUser['password'];

		//need to clear properties after a call like this to make sure username/password aren't used for the get command below
		$user = $testUser->signup();

		$parseUser = new parseUser;
		$return = $parseUser->get($user->objectId);

		\Enhance\Assert::isTrue( property_exists($return,'username') );
	}

	public function queryUsersWithQueryExpectResultsKey(){
		$parseUser = $this->parseUser;
		$userQuery = new parseQuery('users');
		$userQuery->whereExists('phone');
		$return = $userQuery->find();

		\Enhance\Assert::isTrue( property_exists($return, 'results') );

	}

	public function deleteWithObjectIdExpectTrue(){
		$testUser = new parseUser;
		$testUser->username = $this->testUser['username'];
		$testUser->password = $this->testUser['password'];
		
		$user = $testUser->signup();
		
		$parseUser = $this->parseUser;
		$return = $parseUser->delete($user->objectId,$user->sessionToken);
		
		\Enhance\Assert::isTrue( $return );
	}
/*
	THESE TESTS RETURN ERROR EVERYTIME FROM PARSE BECAUSE OF AN INVALID FACEBOOK ID

	public function linkAccountsWithAddAuthDataExpectTrue(){
		$testUser = new parseUser;
		$testUser->username = $this->testUser['username'];
		$testUser->password = $this->testUser['password'];
		
		$user = $testUser->signup();
		
		$parseUser = new parseUser;

		//These technically don't have to be REAL, unless you want them to actually work :)
		$parseUser->addAuthData(array(
			'type' => 'facebook',
			'authData' => array(
				'id' => 'FACEBOOK_ID_HERE',
				'access_token' => 'FACEBOOK_ACCESS_TOKEN',
				'expiration_date' => "2012-12-28T23:49:36.353Z"
			)
		));

		$parseUser->addAuthData(array(
			'type' => 'twitter',
			'authData' => array(
				'id' => 'TWITTER_ID',
				'screen_name' => 'TWITTER_SCREEN_NAME',
				'consumer_key' => 'CONSUMER_KEY',
				'consumer_secret' => 'CONSUMER_SECRET',
				'auth_token' => 'AUTH_TOKEN',
				'auth_token_secret' => 'AUTH_TOKEN_SECRET',
			)
		));
		
		$return = $parseUser->linkAccounts($user->objectId,$user->sessionToken);

		\Enhance\Assert::isTrue( $return );
	}

	
	public function unlinkAccountWith(){
		
	}
*/

}

?>