PHP parse.com API library
===========================
More on the parse.com api here: https://www.parse.com/docs/rest

### Beta Version ###
Working on docs for this version, for now please see the tests folder. 

I wrote tests not for testing sake, but really just to see how I liked how the library worked!

### Feedback Wanted ###

This is a work in progress and is a drasticly different then v1 of this library.

Let me know what you think and suggestions and ideas


SETUP
=========================

** Instructions ** after cloning this repository you have to create a file in the root of it called ** parseConfig.php **

### Below is a sample for parseConfig.php ###

```
<?php

class parseConfig{
	
	static APPID = '';
	static MASTERKEY = '';
	static RESTKEY = '';
	static PARSEURL = 'https://api.parse.com/1/';
}

?>

```