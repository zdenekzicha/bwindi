<?php



/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return IRouter
	 */
	public function createRouter()
	{
		$router = new NRouteList();
		$router[] = new NRoute('index.php', 'Homepage:default', NRoute::ONE_WAY);
		$router[] = new NRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}

}
