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

/**
 * WidgetCompilerPass
 *
 * Compiler pass for widget support
 * @author David Jegat <david.jegat@gmail.com>
 */
class WidgetCompilerPass implements CompilerPassInterface
{
	/**
	 * Process to the compiler pass
	 * 
	 * @param ContainerBuilder $container
	 */
	public function process(CotainerBuilder $container)
	{
		if (!$container->hasDefinition('app.widget_manager')){
			return;
		}

		$definition = $container->getDefinition('app.widget_manager');

		$taggedServices = $container->findTaggedServiceIds('app.widget');

		foreach($taggedServices as $id => $attr){
			$definition->addMethodCall('addWidget', new Reference($id));
		}
	}
}