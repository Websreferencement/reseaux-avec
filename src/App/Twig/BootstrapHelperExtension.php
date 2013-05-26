<?php

namespace App\Twig;

use Twig_Extension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Model\ListableDatasInterface;
use App\Exception\ListableEntityViolation;
use App\Helper\Datatable;

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
	 * @param Datatable $datatable
	 * @param string $title
	 * @return string
	 */
	public function renderDatatable(Datatable $datatable, $title = null)
	{
		if ($title !== null){
			$datatable->setTitle($title);
		}

		return $datatable->render();
	}

	public function getFunctions()
	{
		return array(
			'render_datatable' => new \Twig_Function_Method($this, 'renderDatatable', array(
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