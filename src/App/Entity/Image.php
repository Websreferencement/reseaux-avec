<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use URLify;
use App\Model\ListableDatasInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Entity\ImageRepository")
 * @ORM\Table(name="image")
 * @ORM\HasLifecycleCallbacks
 */
class Image implements ListableDatasInterface
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
     * @var string $thumbSrc
     * @ORM\Column(name="thumb_src", type="string")
     */
    private $thumbSrc;

    /**
     * @var string $content
     * @ORM\Column(name="content", type="text")
     */
    private $content;

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
     * @return Image
     */
    public function setContent($content)
    {
        $this->content = $content;
    
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

    public function getType()
    {
        return 'image';
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
     * @return Image
     */
    public function setThumbSrc($thumbSrc)
    {
        $this->thumbSrc = $thumbSrc;
    
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

		$this->thumbSrc = URLify::filter($this->getName()).
            '.thumb.'.uniqid().
            '.'.$this->file->guessExtension();

        $this->content = URLify::filter($this->getName()).
            '.'.uniqid().
            '.'.$this->file->guessExtension();
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

        $this->file->move($this->getDestinationDirectory(), $this->content);

        copy($this->getAbsolutePath(), $this->getAbsoluteThumbPath());

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
        unlink($this->getAbsoluteThumbPath());
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
     * Get the absolute path to the uploaded directory
     *
     * @return string
     */
    public function getDestinationDirectory()
    {
        return $this->getWebPath().'/'.$this->getUploadDir();
    }

    /**
     * Get the absolute path to the image
     *
     * return string
     */
    public function getAbsolutePath()
    {
        return $this->content ?
            $this->getDestinationDirectory().'/'.$this->content :
            null;
    }

    /**
     * Get the absolute path to the thumbnail
     *
     * @return string
     */
    public function getAbsoluteThumbPath()
    {
        return $this->thumbSrc ?
            $this->getDestinationDirectory().'/'.$this->thumbSrc :
            null;
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

    public function getAssetThumbPath()
    {
        return $this->getUploadDir().'/'.$this->thumbSrc;
    }

    public function getAssetPath()
    {
        return $this->getUploadDir().'/'.$this->content;
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

	public function getListFields()
	{
		return array(
			'Nom de l\'image' => $this->getName(),
			'catégorie' => ($this->category) ? $this->category->getTitle() : 'Aucune'	
		);
	}

	public function __toString()
	{
		return $this->getName();
	}
}
