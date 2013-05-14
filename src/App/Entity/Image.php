<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use URLify;

/**
 * @ORM\Entity(repositoryClass="App\Entity\ImageRepository")
 * @ORM\Table(name="image")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string $name
	 *
	 * @ORM\Column(type="string", length=250)
	 */
	private $name;

	/**
	 * @var string $src
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $src;

	/**
	 * @var string $alt
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $alt;

	/**
	 * @var MediaCategory $category
	 *
	 * @ORM\ManyToOne(targetEntity="MediaCategory", inversedBy="images")
	 */
	private $category;

	/**
	 * @var UploadedFile $file
	 *
	 * @Assert\Image()
	 */
	private $file;

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
	 * @return Image
	 */
	public function setId($id)
	{
		$this->id = $id;
	
		return $this;
	}

	/**
	 * Get name
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Image
	 */
	public function setName($name)
	{
		$this->name = $name;
	
		return $this;
	}

	/**
	 * Get alt
	 * 
	 * @return string
	 */
	public function getAlt()
	{
		return $this->alt;
	}
	
	/**
	 * Set alt
	 *
	 * @param string $alt
	 * @return Image
	 */
	public function setAlt($alt)
	{
		$this->alt = $alt;
	
		return $this;
	}

	/**
	 * Get src
	 * 
	 * @return string
	 */
	public function getSrc()
	{
		return $this->src;
	}
	
	/**
	 * Set src
	 *
	 * @param string $src
	 * @return Image
	 */
	public function setSrc($src)
	{
		$this->src = $src;
	
		return $this;
	}

	/**
	 * Get category
	 * 
	 * @return MediaCategoory
	 */
	public function getCategory()
	{
		return $this->category;
	}
	
	/**
	 * Set category
	 *
	 * @param MediaCategoory $category
	 * @return Image
	 */
	public function setCategory(MediaCategory $category)
	{
		$this->category = $category;
	
		return $this;
	}

	/**
	 * Get file
	 * 
	 * @return UploadedFile
	 */
	public function getFile()
	{
		return $this->file;
	}
	
	/**
	 * Set file
	 *
	 * @param UploadedFile $file
	 * @return Image
	 */
	public function setFile($file)
	{
		$this->file = $file;
	
		return $this;
	}

	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload()
	{
		if (null === $this->file){
			return;
		}

		$this->src = $this->getUploadDir().'/'.
		URLify::filter($this->getName()).'.'.uniqid().'.'.$this->file->guessExtension();
	}

	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function upload()
	{
		if (null === $this->file){
			return;
		}

		if (!is_dir($this->getWebPath().'/'.$this->getUploadDir())){
			mkdir($this->getWebPath().'/'.$this->getUploadDir());
		}

		$this->file->move($this->getWebPath(), $this->src);

		unset($this->file);
	}

	/**
	 * @ORM\PostRemove()
	 */
	public function postRemove()
	{
		if (null === $this->src){
			return;
		}

		unlink($this->getWebPath().'/'.$this->src);
	}

	/**
	 * Return the uploaded as an absolute path directory
	 * 
	 * @return string
	 */
	public function getWebPath()
	{
		return __DIR__.'/../../../web';
	}

	/**
	 * Get the uppload directory from web/
	 * 
	 * @return string
	 */
	public function getUploadDir()
	{
		return 'uploaded';
	}
}