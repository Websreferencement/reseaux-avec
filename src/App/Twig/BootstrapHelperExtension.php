<?php

namespace App\Twig;

use Twig_Extension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Model\ListableDatasInterface;
use App\Exception\ListableEntityViolation;

class BootstrapHelperExtension extends Twig_Extension
{
	/**
	 * @var ContainerInterface $container
	 */
	private $container;

	public function getName()
	{
		return 'bootstrap_helper';
	}

	/**
	 * Check if entities respect the listable interface
	 * 
	 * @param array $entities
	 * @throws ListableEntityViolation
	 */
	public function checkImplementationOfListable(array $datas)
	{
		foreach($datas as $entity){
			if( !is_object($entity) or ! $entity instanceof ListableDatasInterface ){
				throw new ListableEntityViolation(
					sprintf('OUps ! the entity %s must implements the App\\Model\\ListableDatasInterface for 
						being administrable as a table :( !', get_class($entity))
				);
			}
		}
	}

	/**
	 * Display bootstrap datatable
	 * 
	 * @param array $datas
	 * @param string $title
	 * @return string
	 */
	public function datatables(array $datas, $title)
	{
		$this->checkImplementationOfListable($datas);

		if(count($datas)){
			$className = get_class($datas[0]);
			$lastClassInPSR = explode('\\', $className);
			$lastClassInPSR = array_pop($lastClassInPSR);

			$routeName = strtolower($lastClassInPSR);

			$routes = array(
				'create' => 'app_'.$routeName.'_new',
				'edit' => 'app_'.$routeName.'_edit',
				'delete' => 'app_'.$routeName.'_delete'
			);

			$heads = array_keys($datas[0]->getListFields());
		} else {
			$routes = null;
			$heads = null;
		}

		return $this->container
			->get('templating')
			->render('App::Bootstrap/datatable.html.twig', array(
				'title' => $title,
				'datas' => $datas,
				'routes' => $routes,
				'heads' => $heads
			));
	}

	public function getFunctions()
	{
		return array(
			'bootstrap_datatable' => new \Twig_Function_Method($this, 'datatables', array(
				'is_safe' => array('html')
			))
		);
	}

	/**
	 * inject container
	 * 
	 * @param ContainerInterface $container
	 */
	public function setContainer(ContainerInterface $container)
	{
		$this->container = $container;
	}
}