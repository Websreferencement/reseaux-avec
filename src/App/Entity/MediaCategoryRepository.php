<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class MediaCategoryRepository extends EntityRepository
{
	public function findAllAndPopulate()
	{
		return $this->_em->createQueryBuilder()
			->select('category', 'videos', 'images')
			->from('MediaCategory', 'category')
			->leftJoin('category.images', 'images')
			->leftJoin('category.videos', 'videos')
			->getQuery()
			->getResult();	
    }

    public function getImagesAndVideos()
    {
        $videos = $this->_em
            ->getRepository('App:Video')
            ->findAll();

        $images = $this->_em
            ->getRepository('App:Image')
            ->findAll();

        return array_merge($videos, $images);   
    }
}
