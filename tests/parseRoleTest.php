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

        $parseRole2->removeUsersFromRole(array($retUser->objectId));
        $return2 = $parseRole2->update($objectId);
        \Enhance\Assert::isObject($return2);
        \Enhance\Assert::isNotNull($return2->updatedAt);
        
    }
}

// Run the tests
\Enhance\Core::runTests();

?>
