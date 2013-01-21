<?php



$container = require dirname(__FILE__) . '/bootstrap.php';



class ExampleTest extends TesterTestCase
{
	private $container;


	function __construct(NDIContainer $container)
	{
		$this->container = $container;
	}


	function setUp()
	{
	}


	function testSomething()
	{
		Assert::true( true );
	}

}


id(new ExampleTest($container))->run();