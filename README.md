PHP parse.com API library
===========================
### Original Version ###
Availalbe here: https://github.com/apotropaic/parse.com-php-library

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

### Sample of creating a relation ###

```
<?php 
	// addRelation($field,$class,$objectID);

	// ObjectID is the object ID of the row you would like to become a relation 
	$relation_objectID	= "ABBBBBBC";
	// Name of the class where the object ID is found
	$relation_className	= "Book";
	// The id of row you would like to update
	$id					= "BCCCCCCD";

	$parseObject = new parseObject("_User");
	$parseObject->addRelation('books',$relation_className,$relation_objectID);
	$parseObject->update($id);

	// For example the above would add the row with the objectID: ABBBBBBC
	// Found in the Class called: Book
	// To the class '_User' (the user class) 
	// With an objectID of: BCCCCCCD in the column called books
?>
```
