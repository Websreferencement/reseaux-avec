<?php

namespace App\Widget;

use App\Model\AbstractWidget;

class NewsWidget extends AbstractWidget
{
	public function getName()
	{
		return 'news';	
	}

	public function getTemplate()
	{
		return 'news.html.twig';
	}

	public function initialize()
	{
	 	$em = $this->container
	 		->get('doctrine.orm.entity_manager');

	 	$query = $em->createQuery("SELECT n FROM App:News n");

	 	$news = $this->container
	 		->get('knp_paginator')
	 		->paginate($query, 
	 			$this->container->get('request')->query->get('page', 1),
	 			10);

	 	$news->setUsedRoute('frontend');

	 	$news->setParam('page', '/actualites');

	 	$this->args->set('news', $news);
	}
}