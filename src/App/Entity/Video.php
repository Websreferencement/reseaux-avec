<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\ListableDatasInterface;
use Symfony\Component\Validator\Constraints as Assert;
use URLify;

/**
 * @ORM\Entity
 * @ORM\Table(name="video")
 * @ORM\HasLifecycleCallbacks
 */
class Video
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string $embed
	 *
	 * @ORM\Column(type="text")
	 */
	private $embed;

	/**
	 * @var string $name
	 *
	 * @ORM\Column(type="string", length=150)
	 */
	private $name;

	/**
	 * @var string $thumbSrc
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $thumbSrc;

	/**
	 * @var UploadedFile $file
	 * 
	 * @Assert\File()
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
	 * @return Video
	 */
	public function setId($id)
	{
		$this->id = $id;
	
		return $this;
	}

	/**
	 * Get embed
	 * 
	 * @return string
	 */
	public function getEmbed()
	{
		return $this->embed;
	}
	
	/**
	 * Set embed
	 *
	 * @param string $embed
	 * @return Video
	 */
	public function setEmbed($embed)
	{
		$this->embed = $embed;
	
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
	 * @return Video
	 */
	public function setName($name)
	{
		$this->name = $name;
	
		return $this;
	}

	/**
	 * Get thumbSrc
	 * 
	 * @return string
	 */
	public function getThumbSrc()
	{
		return $this->thumbSrc;
	}
	
	/**
	 * Set thumbSrc
	 *
	 * @param string $thumbSrc
	 * @return Video
	 */
	public function setThumbSrc($thumbSrc)
	{
		$this->thumbSrc = $thumbSrc;
	
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
	 * @return Video
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
	public function preFlush()
	{
		if (null === $this->file){
			return;
		}

		$this->thumbSrc = $this->getUploadDir().'/'.
			URLify::filter($this->getName()).'.'.uniqid().'.'.
			$this->file->guessExtension();
	}

	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function postFlush()
	{
		if (null === $this->file){
			return;
		}

		if (!is_dir($this->getWebPath().'/'.$this->getUploadDir())){
			mkdir($this->getWebPath().'/'.$this->getUploadDir());
		}

		$this->file->move($this->getWebPath(), $this->thumbSrc);

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

		unlink($this->getWebPath().'/'.$this->thumbSrc);
	}

	public function getUploadDir()
	{
		return 'video_thumbnail';
	}

	public function getWebPath()
	{
		return __DIR__.'/../../../web/';
	}

	public function getListFields()
	{
		return array(
			'nom de la vidéo' => $this->getName()
		);
	}
}