<?php
include_once 'EnhanceTestFramework.php';
include_once 'parse.php';

\Enhance\Core::discoverTests('tests/');
\Enhance\Core::runTests();


?>