<?php

// Load Nette Framework or autoloader generated by Composer
require dirname(__FILE__) . '/../libs/autoload.php';


$configurator = new NConfigurator;

// Enable Nette Debugger for error visualisation & logging
$configurator->setDebugMode(TRUE); //zakomentovat pro ladeni na serveru.
$configurator->enableDebugger(dirname(__FILE__) . '/../log');

// Enable RobotLoader - this will load all classes automatically
$configurator->setTempDirectory(dirname(__FILE__) . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(dirname(__FILE__))
	->addDirectory(dirname(__FILE__) . '/../libs')
	->register();

// Create Dependency Injection container from config.neon file
$configurator->addConfig(dirname(__FILE__) . '/config/config.neon');
$configurator->addConfig(dirname(__FILE__) . '/config/config.local.neon', NConfigurator::NONE); // none section

$container = $configurator->createContainer();

//$container->router[] = new NRoute('<presenter>/<action>[/<id>]', 'Kids:default');
//$container->router = new NSimpleRouter('Dite:default');

// Setup router using mod_rewrite detection
if (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules())) {
	$container->router[] = new NRoute('index.php', 'Homepage:default', NRoute::ONE_WAY);
	$container->router[] = new NRoute('<presenter>/<action>[/<id>]', 'Homepage:default');

} else {
	$container->router = new NSimpleRouter('Homepage:default');
}

return $container;
