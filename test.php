<?php
include_once 'EnhanceTestFramework.php';
include_once 'parse.php';

//UNCOMMENT AN INDIVIDUAL FILE TESTS OR JUST THE DISCOVERTESTS LINE FOR ALL TESTS
//include_once 'tests/parseObjectTest.php';
//include_once 'tests/parseQueryTest.php';
//include_once 'tests/parseUserTest.php';
//include_once 'tests/parseFileTest.php';
//include_once 'tests/parsePushTest.php';
//include_once 'tests/parseGeoPointTest.php';
\Enhance\Core::discoverTests('tests/');

\Enhance\Core::runTests();


?>