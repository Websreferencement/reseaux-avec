<?php

namespace App\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Help to display a corect datatable for a given 
 * entity
 */
class Datatable
{
	private $container;

	private $repository;

	private $entity;

	private $title;

	/**
	 * Return the view for the given repository
	 * 
	 * @return string
	 */
	public function render()
	{
		if (null === $this->repository){
			throw new \RuntimeException('No repository has been defined for the Datatable helper');
		}

		if (null === $this->entity){
			throw new \RuntimeException('No entity has been defined for the Datatable helper');
		}

		if ($this->repository instanceof DatatableRepositoryInterface) {
			$datas = $this->repository->getDatas();
		} else {
			$datas = $this->repository
				->findAll();
		}

		$heads = false;
		if (!empty($datas)){
			$heads = array();
			foreach($datas[0]->getListFields() as $k => $v){
				$heads[] = $k;
			}
		}

		return $this->container
			->get('templating')
			->render('App::Helper/datatable.html.twig', array(
				'datas' => $datas,
				'routes' => array(
					'create' => 'app_'.lcfirst($this->entity).'_new',
					'edit' => 'app_'.lcfirst($this->entity).'_edit',
					'delete' => 'app_'.lcfirst($this->entity).'_delete'
				),
				'title' => $this->title,
				'heads' => $heads
			));
	}

	public function setRepository(EntityRepository $repo)
	{
		$this->repository = $repo;

		return $this;
	}

	public function setEntity($entity)
	{
		if (is_object($entity)){
			$entity = get_class($entity);
		}


		$exploder = explode('\\', $entity);
		$entity = array_pop($exploder);

		$this->entity = $entity;
		
		if (!is_a('App\\Entity\\'.$entity, 'App\\Model\\ListableDatasInterface', true)){
			throw new \RuntimeException('A class used by the Datatable helper must implements the
				App\\Model\\ListableDatasInterface');
		}

		return $this;
	}

	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
}