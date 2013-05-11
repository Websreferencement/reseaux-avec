<?php

namespace App\Manager;

use Iterator;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractContainer implements Iterator
{
	/**
	 * @var array $contents
	 */
	protected $contents;

	/**
	 * @var ContainerInterface $container
	 */
	protected $container;

	/**
	 * @var integer $iterator
	 */
	protected $iterator;

	/**
	 * Sort the current
	 * 
	 * @return Widget
	 */
	public function current()
	{
		return $this->contents[$this->iterator];
	}

	/**
	 * return the current key
	 * 
	 * @return integer
	 */
	public function key()
	{
		return $this->iterator;
	}

	/**
	 * increment iterator
	 */
	public function next()
	{
		++$this->iterator;
	}

	/**
	 * Reset the iterator
	 */
	public function rewind()
	{
		$this->iterator = 0;
	}

	/**
	 * Test if the current iterator offset exists
	 * 
	 * @return boolean
	 */
	public function valid()
	{
		return isset($this->contents[$this->iterator]);
	}

	/**
	 * default constructor for the WidgetManager
	 * 
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->contents = array();
		$this->container = $container;
		$this->iterator = 0;
	}
}