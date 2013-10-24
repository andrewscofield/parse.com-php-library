<?php

class parseQueryTest extends \Enhance\TestFixture {
	
	public $parseQuery;
	public $parseQueryUser;
	public $parseObject;
	public $parseObject2;
	
	public function setUp(){
		//setup test data to query
		$parseObject = new parseObject('test');
		$parseObject->score = 1111;
		$parseObject->name = 'Foo';
		$parseObject->mode = 'cheat';
		$this->parseObject = $parseObject->save();
		
		$parseObject2 = new parseObject('test');
		$parseObject2->score = 2222;
		$parseObject2->name = 'Bar';
		$parseObject2->mode = 'nocheat';
		$parseObject2->phone = '555-555-1234';
		$parseObject2->object1 = $parseObject2->dataType('pointer', array('test',$this->parseObject->objectId));
		$this->parseObject2 = $parseObject2->save();

		$this->parseQuery = \Enhance\Core::getCodeCoverageWrapper('parseQuery', array('test'));
		$this->parseQueryUser = \Enhance\Core::getCodeCoverageWrapper('parseQuery', array('users'));
		
	}
	
	public function findWithNameExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->where('name','Foo');
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithNameNotExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereNotEqualTo('name','Foo');
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithScoreGreaterExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereGreaterThan('score',1500);
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithScoreLessExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereLessThan('score',1500);
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithScoreGreaterOrEqualExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereGreaterThanOrEqualTo('score',1111);
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithScoreLessOrEqualExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereLessThanOrEqualTo('score',1111);
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithModeContainedInExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereContainedIn('mode',array('cheat','test','mode'));
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithNameNotContainedInExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereNotContainedIn('name',array('cheat','test','mode'));
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithScoreExistsExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereExists('score');
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithScoreDoesNotExistExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereDoesNotExist('score');
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithRegexExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereRegex('name','^\bF.*');
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithInQueryExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereInQuery('object1','test', array('where' => array(
			'name' => array('$exists' => true)
		)));
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	public function findWithNotInQueryExpectResults(){
		$parseQuery = $this->parseQuery;
		$parseQuery->whereNotInQuery('object1','test', array('where' => array(
			'name' => array('$exists' => true)
		)));
		$return = $parseQuery->find();
		
		\Enhance\Assert::isTrue( is_array($return->results) );
	}

	


}
?>