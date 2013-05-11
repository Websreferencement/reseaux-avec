<?php
/*
 * This file is a part of réseaux AVEC. Please read
 * the LICENSE and/or README.md files for more informations
 * about this project.
 */
 
namespace App\Manager;

use App\Model\WidgetInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Exception\WidgetNotFoundException;

/**
 * WidgetManager
 *
 * This manager provides an entire list of widgets
 * @author David Jegat <david.jegat@gmail.com>
 */
class WidgetContainer extends AbstractContainer
{

	/**
	 * Get widgets
	 * 
	 * @return array
	 */
	public function getWidgets()
	{
		return $this->contents;
	}
	
	/**
	 * add widget
	 *
	 * @param Widget $widget
	 * @return widgets
	 */
	public function addWidget(WidgetInterface $widget)
	{
		$this->contents[] = $widget;
	
		return $this;
	}
	
	/**
	 * has widget
	 *
	 * @param Widget|string $widget
	 * @return boolean
	 */
	public function hasWidget($widget)
	{
		foreach($this->contents as $item){
			if($widget instanceof WidgetInterface and $item === $widget){
	
				return true;
			} else if(is_string($widget) and $item->getName() === $widget) {

				return true;
			}
		}
	
		return false;
	}

	/**
	 * get widget
	 *
	 * @param Widget|string $widget
	 * @return Widget or null
	 */
	public function getWidget($widget)
	{
		foreach($this->contents as $item){
			if($widget instanceof WidgetInterface and $item === $widget){
	
				return $item;
			} else if(is_string($widget) and $item->getName() === $widget) {

				return $item;
			}
		}
	
		return null;
	}

	/**
	 * Render the activated widgets
	 * 
	 * @param Widget or string $widget
	 * @throws WidgetNotFoundException
	 * @return string
	 */
	public function render($widget)
	{
		if(null === ($w = $this->getWidget($widget)) ){
			throw new WidgetNotFoundException('No widget has been found for the current page :(');
		}

		return $this->container->get('templating')
			->render('App:Widget:'.$w->getTemplate(), $w->getTemplateArguments());
	}
}