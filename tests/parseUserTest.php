<?php
class parseUserTest extends \Enhance\TestFixture {
	
	private $parseUser;
	private $testUser;
	
	public function setUp(){
		$this->parseUser = \Enhance\Core::getCodeCoverageWrapper('parseUser');
		$this->testUser = array(
			'username' => 'testUser',
			'password' => 'testPass',
			'email' => 'testUser@parse.com',
			'customField' => 'customValue'
		);
	}

	public function signupWithTestuserExpectObjectId(){
		$parseUser = $this->parseUser;

		$return = $parseUser->signup($this->testUser['username'], $this->testUser['password']);
		
		\Enhance\Assert::isTrue( property_exists($return,'objectId') );
	}

	public function signupWithEmailAndCustomFieldExpectObjectId(){
		$parseUser = $this->parseUser;
		$parseUser->username = $this->testUser['username'];
		$parseUSer->password = $this->testUser['password'];
		$parseUser->email = $this->testUser['email'];
		$parseUser->customField = $this->testUser['customField'];

		$return = $parseUser->signup();

		\Enhance\Assert::isTrue( property_exists($return,'objectId') );
	}

	public function signupWithNoUsernameExpectFalse(){
		$parseUser = $this->parseUser;
		$parseUser->password = $this->testUser['password'];

		$return = $parseUser->signup();
		
		\Enhance\Assert::isFalse( $return );
	}

	public function signupWithNoPasswordExpectFalse(){
		$parseUser = $this->parseUser;
		$parseUser->username = $this->testUser['username'];

		$return = $parseUser->signup();
		
		\Enhance\Assert::isFalse( $return );
	}
	
	public function loginWithUsernameAndPasswordExpectObjectId(){
		$parseUser = $this->parseUser;
		$parseUser->username = $this->testUser['username'];
		$parseUser->password = $this->testUser['password'];
		
		$return = $parseUser->login();
	
		\Enhance\Assert::isTrue( property_exists($return,'objectId') );
	}
	
	public function loginWithBadUsernameAndPasswordExpectFalse(){
		$parseUser = $this->parseUser;
		$parseUser->username = $this->testUser['username'];
		$parseUser->password = 'BadPassword';

		$return = $parseUser->login();
		
		\Enhance\Assert::isFalse( $return );
	}

	public function getUserWithObjectIdExpectUsername(){
		$testUser = new ParseUser();
		$testUser->username = $this->testUser['username'];
		$testUser->password = $this->testUser['password'];
		
		//need to clear properties after a call like this to make sure username/password aren't used for the get command below
		$user = $testUser->signup();
		
		$parseUser = $this->parseUser;
		$return = $parseUser->get($user->objectId);

		\Enhance\Assert::isTrue( property_exists($return,'username') );
	}

	public function queryUsersWithQueryExpectResultsKey(){
		$parseUser = $this->parseUser;
		$userQuery = new ParseQuery('','users');
		
		$return = $userQuery->whereExists('phone');

		\Enhance\Assert::isTrue( property_exists($return, 'results') );

	}

	public function deleteWithObjectIdExpectEmpty(){
		$testUser = new ParseUser();
		$testUser->username = $this->testUser['username'];
		$testUser->password = $this->testUser['password'];
		
		$user = $testUser->signup();
		
		$parseUser = $this->parseUser;
		$return = $parseUser->delete($user->objectId,$user->sessionToken);
		
		\Enhance\Assert::isTrue( $return );
	}

	public function linkAccountsWithAddAuthDataExpectTrue(){
		$testUser = new ParseUser();
		$testUser->username = $this->testUser['username'];
		$testUser->password = $this->testUser['password'];
		
		$user = $testUser->signup();
		
		
		$parseUser = $this->parseUser;

		//These technically don't have to be REAL, unless you want them to actually work :)
		$parseUser->addAuthData(array(
			'type' => 'facebook',
			'authData' => array(
				'id' => 'FACEBOOK_ID_HERE',
				'access_token' => 'FACEBOOK_ACCESS_TOKEN',
				'expiration_date' => "yyyy-MM-dd'T'HH:mm:ss.SSS\'Z"
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
		
		$return = $parseUser->linkAccounts();

		\Enhance\Assert::isTrue( $return );
	}


	public function linkAnonymousAccountExpectTrue(){
		$parseUser = $this->parseUser;
		
		$return = $parseUser->linkAnonymousAccount();

		\Enhance\Assert::isTrue( $return );		
	}
	
	public function unlinkAccountWith(){
		
	}

}

?>