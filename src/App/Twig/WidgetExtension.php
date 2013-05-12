<?php

namespace App\Twig;

use Twig_Extension;
use Twig_Function_Method;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Page;

class WidgetExtension extends Twig_Extension
{
	/**
	 * @var ContainerInterface $container
	 */
	private $container;

	/**
	 * Render a given list of widgets by pass a page entity
	 * 
	 * @param Page $page
	 * @return string
	 */
	public function displayWidgets(Page $page)
	{
		$widgets = $page->getWidgets();
		if(!$widgets){
			return;
		}
		$rendering = '';
		$container = $this->container->get('app.widget_container');

		foreach($widgets as $w){
			$rendering = $container->render($w);
		}

		return $rendering;
	}

	/**
	 * Render a given sidebar
	 * 
	 * @param Page $page
	 * @return string
	 */
	public function displaySidebar(Page $page)
	{
		$sidebar = $page->getSidebar();
		if(!$sidebar){
			return;
		}

		return $this->container
			->get('app.sidebar_container')
			->render($sidebar);
	}

	/**
	 * Return the twig functions helpers
	 * 
	 * @return array
	 */
	public function getFunctions()
	{
		return array(
			'display_widgets' => new Twig_Function_Method($this, 'displayWidgets', array('is_safe' => array('html'))),
			'display_sidebar' => new Twig_Function_Method($this, 'displaySidebar', array('is_safe' => array('html')))
		);
	}

	/**
	 * Identify this Twig_Extension
	 * 
	 * @return string
	 */
	public function getName()
	{
		return 'widget';
	}

	/**
	 * Set the contaier
	 * 
	 * @param ContainerInterface $container
	 */
	public function setContainer($container)
	{
		$this->container = $container;
	}
}