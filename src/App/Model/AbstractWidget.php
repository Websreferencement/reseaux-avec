<?php
/*
 * This file is a part of réseaux AVEC. Please read
 * the LICENSE and/or README.md files for more informations
 * about this project.
 */
 
namespace App\Model;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * AbstractWidget
 *
 * This class provides a standard implementation of a widget.
 * @author David Jegat <david.jegat@gmail.com>
 */
abstract class AbstractWidget extends ContainerAware implements WidgetInterface
{
	/**
	 * @var ParameterBag $args
	 */
	public $args;

	/**
	 * Return the template arguments
	 * 
	 * @return array
	 */
	public function getTemplateArguments()
	{
		return $this->args->all();
	}

	/**
	 * Default constructor
	 */
	public function __construct()
	{
		$this->args = new ParameterBag();
	}
}