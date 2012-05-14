<?php
require 'parse.php';

$return = new parseFile('text/plain','Working at Parse is great!');
$save = $return->save('hello.txt');

print_r($save);

?>