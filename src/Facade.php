<?php
/**
 * Laravel 4 - Persistant Settings
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  l4-metatags
 */

namespace NoviCMS\LaravelMetatags;

class Facade extends \Illuminate\Support\Facades\Facade
{
	protected static function getFacadeAccessor()
	{
		return 'NoviCMS\LaravelMetatags\MetatagsManager';
	}
}
