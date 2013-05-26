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
        $request = $this->container->get('request');

        $filterGallery = $request->query->get('c') ?: '*';
        $filterType = $request->query->get('t') ?: '*';

        $this->args->set('selected_category', $filterGallery);
        $this->args->set('selected_type', $filterType);

        $galleries = $this->container
            ->get('app.entity.media_category_repository')
            ->findAll();
        $this->args->set('galleries', $galleries);

        $imagesAndVideos = $this->container
            ->get('app.entity.media_category_repository')
            ->getImagesAndVideos($filterGallery, $filterType);

        $this->args->set('images_videos', $imagesAndVideos);
	}
}
