<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;

class MediaCategoryRepository extends EntityRepository
{
	public function findAllAndPopulate()
	{
		return $this->_em->createQueryBuilder()
			->select('category', 'video', 'image')
			->from('MediaCategory', 'category')
			->leftJoin('category.images', 'image')
			->leftJoin('category.videos', 'video')
			->query()
			->getResult();	
	}
}