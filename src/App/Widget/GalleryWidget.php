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
            ->findAll();

        $request = $this->container->get('request');

        if ($request->query->get('c')) {
            $this->args->set('selected_category',
                $request->query->get('c'));
        } else {
            $this->args->set('selected_category', '*');
        }

        if ($request->query->get('t')) {
            $this->args->set('selected_type', 
                $request->query->get('t'));
        } else {
            $this->args->set('selected_type', '*');
        }

        $this->args->set('galleries', $galleries);

        $imagesAndVideos = $this->container
            ->get('app.entity.media_category_repository')
            ->getImagesAndVideos();

        $this->args->set('images_videos', $imagesAndVideos);
	}
}
