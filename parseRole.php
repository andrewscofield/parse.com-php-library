<?php


/**
 * Handles some of the functionality for Roles described in
 * https://parse.com/docs/rest#roles
 *
 * @author jobiwankanboi
 */
class parseRole extends parseObject {
   
   public function __construct($name) {
       if($name != '') {
           parent::__construct('roles');
           $this->data['name'] = $name;
       } else {
           $this->throwError('include the roleName when creating a parseRole');
       }
    }

    /**
     * Cannot change name of a role.
     * 
     * @param type $name
     * @param type $value
     */
    public function __set($name,$value){
        if($name != '_className' && $name != 'name'){
                $this->data[$name] = $value;
        }
    }

    /*
    		$parseObject->users = array(
		    '__op' => 'AddRelation',
		    'objects' => array( 
		        $parseObject->dataType('pointer', array('post','8TOXdXf3tz')) 
		        $parseObject->dataType('pointer', array('post','Ed1nuqPvc')),
		    )
		);
 */
    
    /**
     * https://parse.com/docs/rest#roles-updating
     * @param type $userIds
     */
    public function addUsersToRole($userIds = array()) {
        $objects = array();
        foreach ($userIds as $userId) {
            $objects[] = $this->dataType('pointer', array('_User', $userId));
        }
        $this->setProperty('users', array(
            '__op' => 'AddRelation',
            'objects' => $objects
        ));
    }

    /**
     * https://parse.com/docs/rest#roles-updating
     * @param type $userIds
     */
    public function removeUsersFromRole($userIds = array()) {
        $objects = array();
        foreach ($userIds as $userId) {
            $objects[] = $this->dataType('pointer', array('_User', $userId));
        }
        $this->setProperty('users', array(
            '__op' => 'RemoveRelation',
            'objects' => $objects
        ));
    }

    /**
     * https://parse.com/docs/rest#roles-creating
     * 
     * @return type
     */
    public function save(){
        if(!$this->data['ACL'])
           $this->throwError('Must have ACL with role');
        if(count($this->data) > 0 && $this->_className != ''){
            $request = $this->request(array(
                    'method' => 'POST',
                    'requestUrl' => $this->_className,
                    'data' => $this->data,
            ));
            return $request;
        }
    }
    
    /**
     * https://parse.com/docs/rest#roles-retrieving
     * @param type $id
     * @return type
     */
    public function get($id){
        if($this->_className != '' || !empty($id)){
            $request = $this->request(array(
                    'method' => 'GET',
                    'requestUrl' => $this->_className.'/'.$id
            ));

            if(!empty($this->_includes)){
                    $request['include'] = implode(',', $this->_includes);
            }

            return $request;
        }
    }

    /**
     * https://parse.com/docs/rest#roles-updating
     * @param type $id
     * @return type
     */
    public function update($id){
        if($this->_className != '' || !empty($id)){
            $request = $this->request(array(
                    'method' => 'PUT',
                    'requestUrl' => $this->_className.'/'.$id,
                    'data' => $this->data,
            ));

            return $request;
        }
    }

    /**
     * https://parse.com/docs/rest#roles-deleting
     * @param type $id
     * @return type
     */
    public function delete($id){
        if($this->_className != '' || !empty($id)){
            $request = $this->request(array(
                    'method' => 'DELETE',
                    'requestUrl' => $this->_className.'/'.$id
            ));

            return $request;
        }		
    }

    /**
     * 
     * @param type $field
     * @param type $amount
     */
    public function increment($field,$amount){
       $this->throwError("function increment makes no sense for role.");
    }
    
    /**
     * 
     * @param type $id
     */
    public function decrement($id){
       $this->throwError("function decrement makes no sense for role.");
    }
    
    
    /**
     * curl -X POST \
  -H "X-Parse-Application-Id: Z0GKPdAmkIZsKg9nGgSGU52DQBUP2xavHmACYsAI" \
  -H "X-Parse-REST-API-Key: lOQHg18qhxveTkNA6YGIWDtwBpwQ9ULyK2ZwPqTh" \
  -H "Content-Type: application/json" \
  -d '{
        "name": "Moderators",
        "ACL": {
          "*": {
            "read": true
          }
        }
      }' \
  https://api.parse.com/1/roles
     */
    
    /**
     * curl -X POST \
  -H "X-Parse-Application-Id: Z0GKPdAmkIZsKg9nGgSGU52DQBUP2xavHmACYsAI" \
  -H "X-Parse-REST-API-Key: lOQHg18qhxveTkNA6YGIWDtwBpwQ9ULyK2ZwPqTh" \
  -H "Content-Type: application/json" \
  -d '{"score":1337,"playerName":"Sean Plott","cheatMode":false}' \
  https://api.parse.com/1/classes/GameScore
     * 
     */
    
    /**
     * curl -X PUT \
  -H "X-Parse-Application-Id: Z0GKPdAmkIZsKg9nGgSGU52DQBUP2xavHmACYsAI" \
  -H "X-Parse-REST-API-Key: lOQHg18qhxveTkNA6YGIWDtwBpwQ9ULyK2ZwPqTh" \
  -H "Content-Type: application/json" \
  -d '{"opponents":{"__op":"AddRelation","objects":[{"__type":"Pointer","className":"Player","objectId":"Vx4nudeWn"}]}}' \
  https://api.parse.com/1/classes/GameScore/Ed1nuqPvcm
     * 
     * curl -X PUT \
  -H "X-Parse-Application-Id: Z0GKPdAmkIZsKg9nGgSGU52DQBUP2xavHmACYsAI" \
  -H "X-Parse-Master-Key: F3ywLEYgKT9JzxQKCX6L2UG7Ni6Aq7oIOlZWxVf0" \
  -H "Content-Type: application/json" \
  -d '{
        "users": {
          "__op": "AddRelation",
          "objects": [
            {
              "__type": "Pointer",
              "className": "_User",
              "objectId": "8TOXdXf3tz"
            },
            {
              "__type": "Pointer",
              "className": "_User",
              "objectId": "g7y9tkhB7O"
            }
          ]
        }
      }' \
  https://api.parse.com/1/roles/mrmBZvsErB
     */
}

?>
