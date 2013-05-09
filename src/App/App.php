<?php

namespace App;

use Knp\RadBundle\AppBundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\DependencyInjection\Compiler\WidgetCompilerPass;

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
	}

}
