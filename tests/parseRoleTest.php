<?php

/**
 *
 * @author jobiwankanobi
 */
include_once('../EnhanceTestFramework.php');
include_once('../parse.php');

class parseRoleTest extends \Enhance\TestFixture {
    
    public $parseRole;
    public $parseUser;
    public $testUser;
    
    public function setUp(){
        parseRestClient::$APPID = '22cASrmG1cWQ8LuV1kNRWjQjjpjf2rA9neNZMlLj';  // test app
        parseRestClient::$MASTERKEY = 'WDXgAfDXybXJpswDacf5M4QzKT22Uxov85D12A8M';
        parseRestClient::$RESTKEY = '6tKoG4XataK6FUKJEOdxjy4xAo9J4taNit0BnMfH';
        parseRestClient::$PARSEURL = 'https://api.parse.com/1/';
        $this->parseRole = \Enhance\Core::getCodeCoverageWrapper('parseRole', array('TestRole'));
        $this->parseUser = new parseUser();
        $this->testUser = array(
                'username' => 'testUser'.rand(),
                'password' => 'testPass',
                'email' => 'testUser@parse.com',
                'customField' => 'customValue'
        );

    }

    public function testCreateRole(){
        $parseRole = $this->parseRole;
        $parseACL = new parseACL();
        $parseACL->setPublicReadAccess(true);
        $parseACL->setPublicWriteAccess(false);
        $parseACL->setWriteAccessForRole('Administrator', true);
        
        $parseRole->ACL( $parseACL->acl );
        try {
            $return = $parseRole->save();
        } catch (ParseLibraryException $e) {
            throw $e;
        }
        \Enhance\Assert::isTrue( is_object($return) );
        \Enhance\Assert::isNotNull($return->objectId);
        $parseRole->setProperty('objectId', $return->objectId);
        
        $parseRole2 = $parseRole;
        $return = $parseRole2->get($parseRole2->getProperty('objectId'));
        \Enhance\Assert::isObject($return);
        
        $return = $parseRole2->delete($parseRole2->getProperty('objectId'));
    }
    
    public function testAddAndRemoveRoleForUser() {
        $parseUser = $this->parseUser;
        $retUser = $parseUser->signup($this->testUser['username'], $this->testUser['password']);

        // Recreate role
        $parseRole = $this->parseRole;
        $parseACL = new parseACL();
        $parseACL->setPublicReadAccess(true);
        $parseACL->setPublicWriteAccess(false);
        $parseACL->setWriteAccessForRole('Administrator', true);
        
        $parseRole->ACL( $parseACL->acl );
        try {
            $return = $parseRole->save();
            $objectId = $return->objectId;
        } catch (ParseLibraryException $e) {
            throw $e;
        }
        
        $parseRole2 = new parseRole('TestRole');
        $parseRole2->addUsersToRole(array($retUser->objectId));
        $return = $parseRole2->update($objectId);
        \Enhance\Assert::isObject($return);
        \Enhance\Assert::isNotNull($return->updatedAt);

        // Query parse role
        $query = new parseQuery('users');
        $query->whereRelatedTo('users', 'Role', $objectId);
        $ret = $query->find();
        \Enhance\Assert::isArray($ret);
        \Enhance\Assert::isTrue(count($ret) == 1);

        $parseRole2->removeUsersFromRole(array($retUser->objectId));
        $return2 = $parseRole2->update($objectId);
        \Enhance\Assert::isObject($return2);
        \Enhance\Assert::isNotNull($return2->updatedAt);

        $parseRole2->delete($objectId);
    }
}

// Run the tests
\Enhance\Core::runTests();

?>
