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
class Video implements ListableDatasInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string $content
	 *
	 * @ORM\Column(type="text")
	 */
	private $content;

	/**
	 * @var string $name
	 *
	 * @ORM\Column(type="string", length=150)
	 */
    private $name;

    /**
     * @var string $alt
     * @ORM\Column(name="alt", type="string")
     */
    private $alt;

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
     * @var string $category
     * @ORM\ManyToOne(targetEntity="MediaCategory", inversedBy="videos")
     */
    private $category;

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

    public function getType()
    {
        return 'video';
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set content
     *
     * @param string $content
     * @return Video
     */
    public function setContent($content)
    {
        $this->content = $content;
    
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
     * @return Video
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    
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
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Set category
     *
     * @param MediaCategory $category
     * @return Video
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

		$this->thumbSrc = URLify::filter($this->getName()).
            '.'.uniqid().
            '.'.$this->file->guessExtension();
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

		$this->file->move($this->getDestinationDirectory(), $this->thumbSrc);

		unset($this->file);
	}

	/**
	 * @ORM\PostRemove()
	 */
	public function postRemove()
	{
		if (null === $this->thumbSrc){
			return;
		}

		unlink($this->getAbsolutePath());
	}

	public function getUploadDir()
	{
		return 'video_thumbnail';
	}

	public function getWebPath()
	{
		return __DIR__.'/../../../web';
    }

    public function getDestinationDirectory()
    {
        return $this->getWebPath().'/'.$this->getUploadDir();
    }

    public function getAbsolutePath()
    {
        return $this->thumbSrc ?
            $this->getDestinationDirectory().'/'.$this->thumbSrc :
            null;
    }

    public function getAssetPath()
    {
        return '';
    }

    public function getAssetThumbPath()
    {
        return $this->getUploadDir().'/'.$this->thumbSrc;
    }

    public function __toString()
    {
        return $this->getName();
    }

	public function getListFields()
	{
		return array(
			'nom de la vidéo' => $this->getName()
		);
	}
}
