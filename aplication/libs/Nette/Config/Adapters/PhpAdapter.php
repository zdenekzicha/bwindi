<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 *
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 * @package Nette\Config\Adapters
 */



/**
 * Reading and generating PHP files.
 *
 * @author     David Grudl
 * @package Nette\Config\Adapters
 */
class NConfigPhpAdapter extends NObject implements IConfigAdapter
{

	/**
	 * Reads configuration from PHP file.
	 * @param  string  file name
	 * @return array
	 */
	public function load($file)
	{
		return NLimitedScope::load($file);
	}



	/**
	 * Generates configuration in PHP format.
	 * @param  array
	 * @return string
	 */
	public function dump(array $data)
	{
		return "<?php // generated by Nette \nreturn " . NPhpHelpers::dump($data) . ';';
	}

}
