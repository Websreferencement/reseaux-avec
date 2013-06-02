<?php

namespace App\Widget;

use App\Model\AbstractWidget;

class ActionWidget extends AbstractWidget
{
	public function getName()
	{
		return 'action';	
	}

	public function getTemplate()
	{
		return 'action.html.twig';
	}

	public function initialize()
	{
	 	$em = $this->container
	 		->get('doctrine.orm.entity_manager');

	 	$query = $em->createQuery("SELECT n FROM App:Action n");

	 	$actions = $this->container
	 		->get('knp_paginator')
	 		->paginate($query, 
	 			$this->container->get('request')->query->get('page', 1),
	 			10);

	 	$actions->setUsedRoute('frontend');

	 	$actions->setParam('page', '/actions');

	 	$this->args->set('actions', $actions);
	}
}
