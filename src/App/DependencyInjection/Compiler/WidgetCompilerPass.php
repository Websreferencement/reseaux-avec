<?php
/*
 * This file is a part of réseaux AVEC. Please read
 * the LICENSE and/or README.md files for more informations
 * about this project.
 */
 
namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Finder\Finder;
use App\Exception\WidgetConstraintViolation;
use Symfony\Component\DependencyInjection\Definition;

/**
 * WidgetCompilerPass
 *
 * Compiler pass for widget support
 * @author David Jegat <david.jegat@gmail.com>
 */
class WidgetCompilerPass implements CompilerPassInterface
{
	/**
	 * Get all the registered widgets
	 * 
	 * @return array
	 */
	private function getWidgets()
	{
		$contents = (new Finder())
			->files()
			->name('*.php')
			->in(dirname(dirname(__DIR__)).'/Widget');

		$classes = array();

		foreach($contents as $file){
			$class = 'App\\Widget\\'.$file->getBasename('.php');
			$reflection = new \ReflectionClass($class);
			if( ! $reflection->implementsInterface('App\\Model\\WidgetInterface') ){
				throw new WidgetConstraintViolation(
					sprintf('The widget %s object must implement the App\\Model\\WidgetInterface interface !', 
						$class)
				);
			}

			if( strlen($file->getBasename('.php')) <= 6 or substr($file->getBasename('.php'), -6) != 'Widget' ) {
				throw new WidgetConstraintViolation(
					sprintf(
						'The widget %s must be named %sWidget !',
						$class,
						$class
					)
				);
			}

			$classes[$file->getBasename('.php')] = 'App\\Widget\\'.$file->getBasename('.php');
		}

		return $classes;
	}

	/**
	 * Dynamicaly create tagged widget service
	 * 
	 * @param ContainerBuilder $container
	 */
	private function createTaggedServices(ContainerBuilder $container)
	{
		foreach($this->getWidgets() as $name => $namespace){
			$definition = new Definition($namespace);
			$definition->addMethodCall('setContainer', array(new Reference('service_container')));
			$definition->addTag('app.widget');

			$container->setDefinition('app.widget.'.strtolower($name), $definition);
		}
	}


	/**
	 * Process to the compiler pass
	 * 
	 * @param ContainerBuilder $container
	 */
	public function process(ContainerBuilder $container)
	{
		if (!$container->hasDefinition('app.widget_container')){
			return;
		}

		$this->createTaggedServices($container);

		$definition = $container->getDefinition('app.widget_container');

		$taggedServices = $container->findTaggedServiceIds('app.widget');

		foreach($taggedServices as $id => $attr){
			$definition->addMethodCall('addWidget', array(new Reference($id)));
		}
	}
}