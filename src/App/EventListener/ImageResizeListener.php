<?php

namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\Image;
use App\Entity\Video;

class ImageResizeListener implements EventSubscriber
{
	private $container;

	public function getSubscribedEvents()
	{
		return array(
			'postPersist',
			'postUpdate'
		);
	}

	public function postPersist(LifecycleEventArgs $args)
	{
		$this->resizeImage($args);
	}

	public function postUpdate(LifecycleEventArgs $args)
	{
		$this->resizeImage($args);
	}

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	private function resizeImage(LifecycleEventArgs $args)
	{
		$img = $args->getEntity();
		if (!$img instanceof Image){
			return $this->resizeVideoThumbnail($args);
		}

		if (null === $img->getContent()){
			return;
		}

        $file = new File($img->getAbsolutePath());
        $thumbnail = new File($img->getAbsoluteThumbPath());

		$imageProcessor = $this->container
			->get('image.handling')
			->open($file->getRealPath())
			->cropResize(800, 600)
            ->save($file->getRealPath(), $file->guessExtension());

        $imageProcessor = $this->container
            ->get('image.handling')
            ->open($thumbnail->getRealPath())
            ->cropResize(200, 150)
            ->save($thumbnail->getRealPath(), $thumbnail->guessExtension());
	}

	private function resizeVideoThumbnail(LifecycleEventArgs $args)
	{
		$video = $args->getEntity();

		if (!$video instanceof Video){
			return;
		}

		if (null === $video->getThumbSrc()){
			return;
		}

		$file = new File($video->getAbsolutePath());

		$imageProcessor = $this->container
			->get('image.handling')
			->open($file->getRealPath())
			->resize(200, 150)
			->save($file->getRealPath(), $file->guessExtension());
	}
}
