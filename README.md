PHP parse.com API library
===========================
More on the parse.com api here: https://www.parse.com/docs/rest

### V1 is still avaialble ###
Availalbe here: https://github.com/apotropaic/parse.com-php-library/blob/parse.com-php-library_v1/README.md

I wrote tests not for testing sake, but really just to see how I liked how the library worked!

### Feedback Wanted ###

This is a work in progress and is a drasticly different then v1 of this library.

Let me know what you think and suggestions and ideas


SETUP
=========================

**Instructions** after cloning this repository you have to create a file in the root of it called **parseConfig.php**

### sample of parseConfig.php ###

Below is what you want parseConfig.php to look like, just fill in your IDs and KEYs to get started.

```
<?php

class parseConfig{
	
	const APPID = '';
	const MASTERKEY = '';
	const RESTKEY = '';
	const PARSEURL = 'https://api.parse.com/1/';
}

?>

```



EXAMPLE
=========================

### sample of upload.php ###

```
<?php 
    //This example is a sample video upload stored in parse
    
    $parse = new parseObject('Videos');
    $parse->title = $data['upload_data']['title'];
    $parse->description = $data['upload_data']['description'];
    $parse->tags = $data['upload_data']['tags'];
    
    //create new geo
    $geo = new parseGeoPoint($data['upload_data']['lat'],$data['upload_data']['lng']);
    $parse->location = $geo->location;
    
    //use pointer to other class
    $parse->userid = array("__type" => "Pointer", "className" => "_User", "objectId" => $data['upload_data']['userid']);
    
    //create acl
    $parse->ACL = array("*" => array("write" => true, "read" => true));
    $r = $parse->save();
    ?>
```