<?php //netteCache[01]000360a:2:{s:4:"time";s:21:"0.44836000 1358799471";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:56:"/home/www/zweb.cz/www/dev.zweb.cz/app/config/config.neon";i:2;i:1358798249;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:62:"/home/www/zweb.cz/www/dev.zweb.cz/app/config/config.local.neon";i:2;i:1358798248;}}}?><?php
// source: /home/www/zweb.cz/www/dev.zweb.cz/app/config/config.neon production
// source: /home/www/zweb.cz/www/dev.zweb.cz/app/config/config.local.neon 

/**
 * @property NApplication $application
 * @property Authenticator $authenticator
 * @property NFileStorage $cacheStorage
 * @property NDINestedAccessor $constants
 * @property NDIContainer $container
 * @property NHttpRequest $httpRequest
 * @property NHttpResponse $httpResponse
 * @property SystemContainer_nette $nette
 * @property NDINestedAccessor $php
 * @property IRouter $router
 * @property RouterFactory $routerFactory
 * @property NSession $session
 * @property NUser $user
 */
class SystemContainer extends NDIContainer
{

	public $classes = array(
		'nobject' => FALSE, //: nette.cacheJournal, cacheStorage, nette.httpRequestFactory, httpRequest, httpResponse, nette.httpContext, session, nette.userStorage, user, application, nette.mailer, nette.database, authenticator, container,
		'icachejournal' => 'nette.cacheJournal',
		'nfilejournal' => 'nette.cacheJournal',
		'icachestorage' => 'cacheStorage',
		'nfilestorage' => 'cacheStorage',
		'nhttprequestfactory' => 'nette.httpRequestFactory',
		'ihttprequest' => 'httpRequest',
		'nhttprequest' => 'httpRequest',
		'ihttpresponse' => 'httpResponse',
		'nhttpresponse' => 'httpResponse',
		'nhttpcontext' => 'nette.httpContext',
		'nsession' => 'session',
		'iuserstorage' => 'nette.userStorage',
		'nuserstorage' => 'nette.userStorage',
		'nuser' => 'user',
		'napplication' => 'application',
		'ipresenterfactory' => 'nette.presenterFactory',
		'npresenterfactory' => 'nette.presenterFactory',
		'irouter' => 'router',
		'imailer' => 'nette.mailer',
		'nsendmailmailer' => 'nette.mailer',
		'ndinestedaccessor' => 'nette.database',
		'pdo' => 'nette.database.default',
		'nconnection' => 'nette.database.default',
		'routerfactory' => 'routerFactory',
		'iauthenticator' => 'authenticator',
		'authenticator' => 'authenticator',
		'nfreezableobject' => 'container',
		'ifreezable' => 'container',
		'idicontainer' => 'container',
		'ndicontainer' => 'container',
	);

	public $meta = array();


	public function __construct()
	{
		parent::__construct(array(
			'appDir' => '/home/www/zweb.cz/www/dev.zweb.cz/app',
			'wwwDir' => '/home/www/zweb.cz/www/dev.zweb.cz/www',
			'debugMode' => FALSE,
			'productionMode' => TRUE,
			'environment' => 'production',
			'consoleMode' => FALSE,
			'container' => array(
				'class' => 'SystemContainer',
				'parent' => 'NDIContainer',
			),
			'tempDir' => '/home/www/zweb.cz/www/dev.zweb.cz/app/../temp',
		));
	}


	/**
	 * @return NApplication
	 */
	protected function createServiceApplication()
	{
		$service = new NApplication($this->getService('nette.presenterFactory'), $this->getService('router'), $this->getService('httpRequest'), $this->getService('httpResponse'));
		$service->catchExceptions = TRUE;
		$service->errorPresenter = 'Error';
		NRoutingDebugger::initializePanel($service);
		return $service;
	}


	/**
	 * @return Authenticator
	 */
	protected function createServiceAuthenticator()
	{
		$service = new Authenticator($this->getService('nette.database.default'));
		return $service;
	}


	/**
	 * @return NFileStorage
	 */
	protected function createServiceCacheStorage()
	{
		$service = new NFileStorage('/home/www/zweb.cz/www/dev.zweb.cz/app/../temp/cache', $this->getService('nette.cacheJournal'));
		return $service;
	}


	/**
	 * @return NDINestedAccessor
	 */
	protected function createServiceConstants()
	{
		$service = new NDINestedAccessor($this, 'constants');
		return $service;
	}


	/**
	 * @return NDIContainer
	 */
	protected function createServiceContainer()
	{
		return $this;
	}


	/**
	 * @return NHttpRequest
	 */
	protected function createServiceHttpRequest()
	{
		$service = $this->getService('nette.httpRequestFactory')->createHttpRequest();
		if (!$service instanceof NHttpRequest) {
			throw new UnexpectedValueException('Unable to create service \'httpRequest\', value returned by factory is not NHttpRequest type.');
		}
		return $service;
	}


	/**
	 * @return NHttpResponse
	 */
	protected function createServiceHttpResponse()
	{
		$service = new NHttpResponse;
		return $service;
	}


	/**
	 * @return NDINestedAccessor
	 */
	protected function createServiceNette()
	{
		$service = new NDINestedAccessor($this, 'nette');
		return $service;
	}


	/**
	 * @return NForm
	 */
	public function createNette__basicForm()
	{
		$service = new NForm;
		return $service;
	}


	/**
	 * @return NCallback
	 */
	protected function createServiceNette__basicFormFactory()
	{
		$service = new NCallback($this, 'createNette__basicForm');
		return $service;
	}


	/**
	 * @return NCache
	 */
	public function createNette__cache($namespace = NULL)
	{
		$service = new NCache($this->getService('cacheStorage'), $namespace);
		return $service;
	}


	/**
	 * @return NCallback
	 */
	protected function createServiceNette__cacheFactory()
	{
		$service = new NCallback($this, 'createNette__cache');
		return $service;
	}


	/**
	 * @return NFileJournal
	 */
	protected function createServiceNette__cacheJournal()
	{
		$service = new NFileJournal('/home/www/zweb.cz/www/dev.zweb.cz/app/../temp');
		return $service;
	}


	/**
	 * @return NDINestedAccessor
	 */
	protected function createServiceNette__database()
	{
		$service = new NDINestedAccessor($this, 'nette.database');
		return $service;
	}


	/**
	 * @return NConnection
	 */
	protected function createServiceNette__database__default()
	{
		$service = new NConnection('mysql:host=localhost;dbname=test', NULL, NULL, NULL);
		$service->setCacheStorage($this->getService('cacheStorage'));
		NDebugger::$blueScreen->addPanel('NDatabasePanel::renderException');
		$service->setDatabaseReflection(new NDiscoveredReflection($this->getService('cacheStorage')));
		return $service;
	}


	/**
	 * @return NHttpContext
	 */
	protected function createServiceNette__httpContext()
	{
		$service = new NHttpContext($this->getService('httpRequest'), $this->getService('httpResponse'));
		return $service;
	}


	/**
	 * @return NHttpRequestFactory
	 */
	protected function createServiceNette__httpRequestFactory()
	{
		$service = new NHttpRequestFactory;
		$service->setEncoding('UTF-8');
		return $service;
	}


	/**
	 * @return NLatteFilter
	 */
	public function createNette__latte()
	{
		$service = new NLatteFilter;
		return $service;
	}


	/**
	 * @return NCallback
	 */
	protected function createServiceNette__latteFactory()
	{
		$service = new NCallback($this, 'createNette__latte');
		return $service;
	}


	/**
	 * @return NMail
	 */
	public function createNette__mail()
	{
		$service = new NMail;
		$service->setMailer($this->getService('nette.mailer'));
		return $service;
	}


	/**
	 * @return NCallback
	 */
	protected function createServiceNette__mailFactory()
	{
		$service = new NCallback($this, 'createNette__mail');
		return $service;
	}


	/**
	 * @return NSendmailMailer
	 */
	protected function createServiceNette__mailer()
	{
		$service = new NSendmailMailer;
		return $service;
	}


	/**
	 * @return NPresenterFactory
	 */
	protected function createServiceNette__presenterFactory()
	{
		$service = new NPresenterFactory('/home/www/zweb.cz/www/dev.zweb.cz/app', $this);
		return $service;
	}


	/**
	 * @return NFileTemplate
	 */
	public function createNette__template()
	{
		$service = new NFileTemplate;
		$service->registerFilter($this->createNette__latte());
		$service->registerHelperLoader('NTemplateHelpers::loader');
		return $service;
	}


	/**
	 * @return NPhpFileStorage
	 */
	protected function createServiceNette__templateCacheStorage()
	{
		$service = new NPhpFileStorage('/home/www/zweb.cz/www/dev.zweb.cz/app/../temp/cache', $this->getService('nette.cacheJournal'));
		return $service;
	}


	/**
	 * @return NCallback
	 */
	protected function createServiceNette__templateFactory()
	{
		$service = new NCallback($this, 'createNette__template');
		return $service;
	}


	/**
	 * @return NUserStorage
	 */
	protected function createServiceNette__userStorage()
	{
		$service = new NUserStorage($this->getService('session'));
		return $service;
	}


	/**
	 * @return NDINestedAccessor
	 */
	protected function createServicePhp()
	{
		$service = new NDINestedAccessor($this, 'php');
		return $service;
	}


	/**
	 * @return IRouter
	 */
	protected function createServiceRouter()
	{
		$service = $this->getService('routerFactory')->createRouter();
		if (!$service instanceof IRouter) {
			throw new UnexpectedValueException('Unable to create service \'router\', value returned by factory is not IRouter type.');
		}
		return $service;
	}


	/**
	 * @return RouterFactory
	 */
	protected function createServiceRouterFactory()
	{
		$service = new RouterFactory;
		return $service;
	}


	/**
	 * @return NSession
	 */
	protected function createServiceSession()
	{
		$service = new NSession($this->getService('httpRequest'), $this->getService('httpResponse'));
		$service->setExpiration('14 days');
		return $service;
	}


	/**
	 * @return NUser
	 */
	protected function createServiceUser()
	{
		$service = new NUser($this->getService('nette.userStorage'), $this);
		return $service;
	}


	public function initialize()
	{
		date_default_timezone_set('Europe/Prague');
		NFileStorage::$useDirectories = TRUE;

		$this->session->exists() && $this->session->start();
		header('X-Frame-Options: SAMEORIGIN');
	}

}



/**
 * @property NConnection $default
 */
class SystemContainer_nette_database
{



}



/**
 * @method NForm createBasicForm()
 * @property NCallback $basicFormFactory
 * @method NCache createCache()
 * @property NCallback $cacheFactory
 * @property NFileJournal $cacheJournal
 * @property SystemContainer_nette_database $database
 * @property NHttpContext $httpContext
 * @method NLatteFilter createLatte()
 * @property NCallback $latteFactory
 * @method NMail createMail()
 * @property NCallback $mailFactory
 * @property NSendmailMailer $mailer
 * @property NPresenterFactory $presenterFactory
 * @method NFileTemplate createTemplate()
 * @property NPhpFileStorage $templateCacheStorage
 * @property NCallback $templateFactory
 * @property NUserStorage $userStorage
 */
class SystemContainer_nette
{



}
