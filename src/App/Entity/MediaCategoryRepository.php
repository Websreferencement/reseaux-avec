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

    public function getVideosFilterByCategory($category)
    {
        if ($category == '*') {
            return $this->_em
                ->getRepository('App:Video')
                ->findAll();
        }

        return $this->_em
            ->createQueryBuilder()
            ->select('v')
            ->from('App:Video', 'v')
            ->leftJoin('v.category', 'c')
            ->where('c.title = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function getImagesFIlterByCategory($category)
    {
        if ($category == '*' ) {
            return $this->_em
                ->getRepository('App:Image')
                ->findAll();
        }

        return $this->_em
            ->createQueryBuilder()
            ->select('i')
            ->from('App:Image', 'i')
            ->leftJoin('i.category', 'c')
            ->where('c.title = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function getImagesAndVideos($category, $type)
    {
        if ($type == '*') {
            return array_merge(
                $this->getVideosFilterByCategory($category),
                $this->getImagesFilterByCategory($category)
            );
        } else {
            if ($type == 'video') {
                return $this->getVideosFilterByCategory($category);
            } else {
                return $this->getImagesFilterByCategory($category);
            }
        }         
    }
}
