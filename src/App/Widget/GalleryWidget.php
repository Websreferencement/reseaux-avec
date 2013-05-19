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
			->get('app.entity.media_category_repository')
			->findAllAndPopulate();

		$this->args->set('galleries', $galleries);

		return;
	}
}