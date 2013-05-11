<?php

namespace App;

use Knp\RadBundle\AppBundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\DependencyInjection\Compiler\WidgetCompilerPass;
use App\DependencyInjection\Compiler\SidebarCompilerPass;

class App extends Bundle
{

	/**
	 * Build the dependency injection
	 * 
	 * @param ContainerBuilder $builder
	 */
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		$container->addCompilerPass(new WidgetCompilerPass());
		$container->addCompilerPass(new SidebarCompilerPass());

	}

}
