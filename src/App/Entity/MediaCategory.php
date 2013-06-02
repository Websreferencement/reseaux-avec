<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Model\ListableDatasInterface;

/**
 * @ORM\Entity(repositoryClass="App\Entity\MediaCategoryRepository")
 * @ORM\Table(name="media_category")
 */
class MediaCategory implements ListableDatasInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string $title
	 *
	 * @ORM\Column(type="string", length=250)
	 */
	private $title;

	/**
	 * @var ArrayCollection $images
	 *
	 * @ORM\OneToMany(targetEntity="Image", mappedBy="category")
	 */
	private $images;

	/**
	 * @var ArrayCollection $videos
	 *
	 * @ORM\OneToMany(targetEntity="Video", mappedBy="category")
	 */
	private $videos;

	/**
	 * Get id
	 * 
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set id
	 *
	 * @param integer $id
	 * @return MediaCategory
	 */
	public function setId($id)
	{
		$this->id = $id;
	
		return $this;
	}

	/**
	 * Get title
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * Set title
	 *
	 * @param string $title
	 * @return MediaCategory
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	
		return $this;
	}

	/**
	 * Get images
	 * 
	 * @return ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}
	
	/**
	 * add image
	 *
	 * @param Image $image
	 * @return images
	 */
	public function addImage(Image $image)
	{
		$this->images[] = $image;
	
		return $this;
	}
	
	/**
	 * has image
	 *
	 * @param Image $image
	 * @return boolean
	 */
	public function hasImage(Video $image)
	{
		foreach($this->images as $item){
			if($item === $image){
	
				return true;
			}
		}
	
		return false;
	}
	
	/**
	 * remove image
	 *
	 * @param Image $image
	 * @return images
	 */
	public function removeImage(Image $image)
	{
		foreach($this->images as $item){
			if($item === $image){
	
				unset($this->images[$key]);
			}
		}
	
		return $this;
	}

	/**
	 * Get videos
	 * 
	 * @return ArrayCollection
	 */
	public function getVideos()
	{
		return $this->videos;
	}
	
	/**
	 * add video
	 *
	 * @param Video $video
	 * @return videos
	 */
	public function addVideo(Video $video)
	{
		$this->videos[] = $video;
	
		return $this;
	}
	
	/**
	 * has video
	 *
	 * @param Video $video
	 * @return boolean
	 */
	public function hasVideo(Video $video)
	{
		foreach($this->videos as $item){
			if($item === $video){
	
				return true;
			}
		}
	
		return false;
	}
	
	/**
	 * remove video
	 *
	 * @param Video $video
	 * @return videos
	 */
	public function removeVideo(Video $video)
	{
		foreach($this->videos as $item){
			if($item === $video){
	
				unset($this->videos[$key]);
			}
		}
	
		return $this;
	}

	public function getListFields()
	{
		return array(
			'Nom de la catégorie' => $this->getTitle(),
		);
	}

    public function getShowRole()
    {
        return 'ROLE_ADMIN';
    }

    public function getEditRole()
    {
        return 'ROLE_ADMIN';
    }

    public function getDeleteRole()
    {
        return 'ROLE_ADMIN';
    }

    public function getCreateRole()
    {
        return 'ROLE_ADMIN';
    }

	public function __toString()
	{
		return $this->getTitle();
	}

	public function getImagesAndVideos()
	{
		$imagesAndVideos = array_merge(
			$this->getImages()->toArray(),
			$this->getVideos()->toArray()
		);

		return $imagesAndVideos;
	}
}
