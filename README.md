PHP parse.com API library
===========================
More on the parse.com api here: https://www.parse.com/docs/rest

NEW version available for testing
==================================
Its on 2.0/master branch of this repository. Check it out here: https://github.com/apotropaic/parse.com-php-library/tree/2.0/master



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
  
NOTIFICATION EXAMPLE
----------------

```
$params = array(
  'object' => array(
    'channel' => 'Andrew Scofield',
    'data' => array(
      'alert' => 'Joey Votto makes another home run!',
      'sound' => 'default',
      'badge' => 0,
      'type'  => 'score',
    )
  )
);

$request = $parse->notification($params);
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
    'object' => array(),
    'query' => array(
        'score' => array(
            '$gt' => 500
        )
    ),
    'order' => '-score',
    'limit' => '2',
    'skip' => '2'
);

$request = $parse->query($params);
```

RELATION QUERY EXAMPLE
----------------------

```
$params = array(
    'className' => 'User',
    'query' => array(
        '$relatedTo' => array(
            'object' => array(
                '__type' => 'Pointer',
                'className' => 'Post',
                'objectId' => $postId
            ),
            'key' => 'like'
        )
    )
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

