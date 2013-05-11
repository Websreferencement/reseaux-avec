<?php

namespace App\Manager;

use App\Model\WidgetInterface;
use App\Exception\WidgetNotFoundException;

class SidebarContainer extends AbstractContainer
{
	/**
	 * Get sidebars
	 * 
	 * @return array
	 */
	public function getSidebars()
	{
		return $this->contents;
	}
	
	/**
	 * add widget
	 *
	 * @param Widget $widget
	 * @return widgets
	 */
	public function addSidebar(WidgetInterface $sidebar)
	{
		$this->contents[] = $sidebar;
	
		return $this;
	}
	
	/**
	 * has sidebar
	 *
	 * @param Widget|string $widget
	 * @return boolean
	 */
	public function hasSidebar($sidebar)
	{
		foreach($this->contents as $item){
			if($sidebar instanceof WidgetInterface and $item === $sidebar){
	
				return true;
			} else if(is_string($sidebar) and $item->getName() === $sidebar) {

				return true;
			}
		}
	
		return false;
	}

	/**
	 * get sidebar
	 *
	 * @param Widget|string $sidebar
	 * @return Widget or null
	 */
	public function getSidebar($sidebar)
	{
		foreach($this->contents as $item){
			if($sidebar instanceof WidgetInterface and $item === $sidebar){
	
				return $item;
			} else if(is_string($sidebar) and $item->getName() === $sidebar) {

				return $item;
			}
		}
	
		return null;
	}

	/**
	 * Render the activated sidebar
	 * 
	 * @param Widget or string $sidebar
	 * @throws WidgetNotFoundException
	 * @return string
	 */
	public function render($sidebar)
	{
		if(null === ($w = $this->getSidebar($sidebar)) ){
			throw new WidgetNotFoundException('No sidebar has been found for the current page :(');
		}

		$w->initialize();

		return $this->container->get('templating')
			->render('App:Sidebar:'.$w->getTemplate(), $w->getTemplateArguments());
	}
}