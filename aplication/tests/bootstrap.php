<?php

require dirname(__FILE__) . '/../libs/autoload.php';

if (!include dirname(__FILE__) . '/../libs/Nette/tester/Tester/bootstrap.php') {
	die('Install Nette Tester using `composer update --dev`');
}

function id($val) {
	return $val;
}

$configurator = new NConfigurator;
$configurator->setDebugMode(FALSE);
$configurator->setTempDirectory(dirname(__FILE__) . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(dirname(__FILE__) . '/../app')
	->register();

$configurator->addConfig(dirname(__FILE__) . '/../app/config/config.neon');
$configurator->addConfig(dirname(__FILE__) . '/../app/config/config.local.neon', NConfigurator::NONE); // none section
return $configurator->createContainer();
