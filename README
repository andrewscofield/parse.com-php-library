PHP parse.com API library
===========================
More on the parse.com api here: https://www.parse.com/docs/rest

### Authentication Fixed ###
The authentication method was recently change on parse's api, a fix has been made on this library.

### Breaking change in recent commit ###
In order to be consistent with parse's terminology I've changed the variable from $masterkey to $restkey
When creating a new instance, use 'restkey' in your array now instead of 'masterkey'




**Please note**
I am working to keep up with their rapidly growing API, please submit any issues you may find. I'll work my best at keep this library up to date. If you are able to send pull requests my way!



Some examples on how to use this library:

CREATE OBJECT
--------------

```
$parse = new parseRestClient(array(
	'appid' => 'YOUR APPLICATION ID',
	'restkey' => 'YOUR REST KEY ID'
));
```

CREATE EXAMPLE
----------------

```
$params = array(
    'className' => 'gameScore',
    'object' => array(
    	'score' => 500,
    	'name' => 'Andrew Scofield'
    )
);

$request = $parse->create($params);
```
  
GET EXAMPLE
------------

 ```
$params = array(
    'className' => 'gameScore',
    'objectId' => 'Ed1nuqPvcm'
);

$request = $parse->get($params);
```

QUERY EXAMPLE
--------------

```
$params = array(
    'className' => 'gameScore',
    'query' => array(
    	'score'=> array(
    		'$gt' => 500
    	) 
    ),
    'order' => '-score',
    'limit' => '2',
    'skip' => '2'
);

$request = $parse->query($params);
```

UPDATE EXAMPLE
---------------

```
$params = array(
    'className' => 'gameScore',
    'objectId' => 'Ed1nuqPvcm',
    'object' => array(
    	'score' => 500,
    	'name' => 'Andrew Scofield'
    )
);

$request = $parse->update($params);
```  

DELETE EXAMPLE
----------------

```
$params = array(
    'className' => 'gameScore',
    'objectId' => 'Ed1nuqPvcm',
);

$request = $parse->delete($params); 
```
