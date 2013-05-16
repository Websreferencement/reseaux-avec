<?php

namespace App\Widget;

use App\Model\AbstractWidget;

class GalleryWidget extends AbstractWidget
{

	public function getTemplate()
	{
		return 'gallery.html.twig';
	}

	public function getName()
	{
		return 'gallery';
	}

	public function initialize()
	{
		$galleries = $this->container
			->get('doctrine.orm.entity_manager')
			->createQueryBuilder()
			->select('category', 'video', 'image')
			->from('MediaCategory', 'category')
			->leftJoin('category.images', 'image')
			->leftJoin('category.videos', 'video')
			->query()
			->getResult();

		$this->args->set('galleries', $galleries);

		return;
	}
}