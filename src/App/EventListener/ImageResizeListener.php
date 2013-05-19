<?php

namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File;
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

		if (null === $img->getSrc()){
			return;
		}

		$file = new File($img->getWebPath().'/'.$img->getSrc());

		$imageProcessor = $this->container
			->get('image.handling')
			->open($file->getRealPath())
			->resize(800, 600)
			->save($file->getRealPath(), $file->guessExtension());
	}

	private function resizeVideoThumbnail(LifecycleEventArgs $args)
	{
		$video = $arg->getEntity();

		if (!$video instanceof Video){
			return;
		}

		if (null === $video->getThumbSrc()){
			return;
		}

		$file = new File($video->getWebPath().'/'.$video->getThumbSrc());

		$imageProcessor = $this->container
			->get('image.handling')
			->open($file->getRealPath())
			->resize(150, 100)
			->save($file>getRealPath(), $file->guessExtension());
	}
}