<?php
/**
 * Laravel 4 - Persistant Settings
 * 
 * @author   Andreas Lutro <anlutro@gmail.com>
 * @license  http://opensource.org/licenses/MIT
 * @package  l4-metatags
 */

namespace NoviCMS\LaravelMetatags;

class MemoryMetatagStore extends MetatagStore
{
	/**
	 * @param array $data
	 */
	public function __construct(array $data = null)
	{
		if ($data) {
			$this->data = $data;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	protected function read()
	{
		return $this->data;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function write(array $data)
	{
		// do nothing
	}
}
