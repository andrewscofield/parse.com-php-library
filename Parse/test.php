<?php
include_once 'RestClient.php';
include_once 'parseConfig.php';
include_once 'Object.php';
include_once 'Query.php';
include_once 'User.php';
include_once 'File.php';
include_once 'Push.php';
include_once 'GeoPoint.php';
include_once 'ACL.php';
include_once 'Cloud.php';
include_once 'EnhanceTestFramework.php';

//UNCOMMENT AN INDIVIDUAL FILE TESTS OR JUST THE DISCOVERTESTS LINE FOR ALL TESTS

// include_once 'tests/parseGeoPointTest.php';
// include_once 'tests/parseFileTest.php';
// include_once 'tests/parseObjectTest.php';
// include_once 'tests/parseQueryTest.php';
// include_once 'tests/parseUserTest.php';
// include_once 'tests/parsePushTest.php';
\Enhance\Core::discoverTests('tests/');

\Enhance\Core::runTests();


?>