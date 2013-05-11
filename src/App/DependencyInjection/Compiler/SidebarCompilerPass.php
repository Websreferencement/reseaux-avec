<?php

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Finder\Finder;
use App\Exception\WidgetConstraintViolation;
use Symfony\Component\DependencyInjection\Definition;

/**
 * SidebarCompilerPass
 * 
 * @author david jegat <david.jegat@gmail.com>
 */
class SidebarCompilerPass implements CompilerPassInterface
{
	/**
	 * Get all the registered sidebar
	 * 
	 * @return array
	 */
	private function getSidebars()
	{
		$contents = (new Finder())
			->files()
			->name('*.php')
			->in(dirname(dirname(__DIR__)).'/Sidebar');

		$classes = array();

		foreach($contents as $file){
			$class = 'App\\Sidebar\\'.$file->getBasename('.php');
			$reflection = new \ReflectionClass($class);
			if( ! $reflection->implementsInterface('App\\Model\\WidgetInterface') ){
				throw new WidgetConstraintViolation(
					sprintf('The sidebar %s object must implement the App\\Model\\WidgetInterface interface !', 
						$class)
				);
			}

			if( strlen($file->getBasename('.php')) <= 7 or substr($file->getBasename('.php'), -7) != 'Sidebar' ) {
				throw new WidgetConstraintViolation(
					sprintf(
						'The sidebar %s must be named %Sidebar !',
						$class,
						$class
					)
				);
			}

			$classes[$file->getBasename('.php')] = 'App\\Sidebar\\'.$file->getBasename('.php');
		}

		return $classes;
	}

	/**
	 * Dynamicaly create tagged sidebar service
	 * 
	 * @param ContainerBuilder $container
	 */
	private function createTaggedServices(ContainerBuilder $container)
	{
		foreach($this->getSidebars() as $name => $namespace){
			$definition = new Definition($namespace);
			$definition->addMethodCall('setContainer', array(new Reference('service_container')));
			$definition->addTag('app.sidebar');

			$container->setDefinition('app.sidebar.'.strtolower(str_replace('Sidebar', '', $name)), $definition);
		}
	}


	/**
	 * Process to the compiler pass
	 * 
	 * @param ContainerBuilder $container
	 */
	public function process(ContainerBuilder $container)
	{
		if (!$container->hasDefinition('app.sidebar_container')){
			return;
		}

		$this->createTaggedServices($container);

		$definition = $container->getDefinition('app.sidebar_container');

		$taggedServices = $container->findTaggedServiceIds('app.sidebar');

		foreach($taggedServices as $id => $attr){
			$definition->addMethodCall('addSidebar', array(new Reference($id)));
		}
	}
}