<?php

namespace App\Twig;

use \Twig_Extension;
use \Twig_Function_Method;
use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SliderExtension extends Twig_Extension
{
	/**
	 * @var ContainerInterface $container
	 */
	private $container;

	public function getName()
	{
		return 'slider';
	}

	public function getSliderAssets()
	{
		$sliders = array();
		$iterator = (new Finder())
			->files('*')
			->in(dirname(__DIR__).'/Resources/public/images/slider');

		$assetsHelper = $this->container->get('templating.helper.assets');

		foreach($iterator as $file){
			$sliders[] = $assetsHelper->getUrl('bundles/app/images/slider/'.$file->getBasename());
		}

		return json_encode($sliders);
	}

	public function getFunctions()
	{
		return array(
			'slider_assets' => new Twig_Function_Method($this, 'getSliderAssets')
		);
	}

	public function setContainer(ContainerInterface $container)
	{
		$this->container = $container;
	}
}