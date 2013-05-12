<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use App\Model\ListableDatasInterface;
use URLify;


/**
 * @ORM\Entity(repositoryClass="App\Entity\NewsRepository")
 * @ORM\Table(name="news")
 * @ORM\HasLifecycleCallbacks
 */
class News implements ListableDatasInterface
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
	 * @var string $uri
	 *
	 * @ORM\Column(type="string", length=250)
	 */
	private $uri;

	/**
	 * @var string $description
	 *
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @var string $content
	 *
	 * @ORM\Column(type="text")
	 */
	private $content;

	/**
	 * @var DateTime $createdAt
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

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
	 * @return News
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
	 * @return News
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	
		return $this;
	}

	/**
	 * Get description
	 * 
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}
	
	/**
	 * Set description
	 *
	 * @param string $description
	 * @return News
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	
		return $this;
	}

	/**
	 * Get uri
	 * 
	 * @return string
	 */
	public function getUri()
	{
		return $this->uri;
	}
	
	/**
	 * Set uri
	 *
	 * @param string $uri
	 * @return News
	 */
	public function setUri($uri)
	{
		$this->uri = $uri;
	
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
	 * @return News
	 */
	public function setContent($content)
	{
		$this->content = $content;
	
		return $this;
	}

	/**
	 * Get createdAt
	 * 
	 * @return string
	 */
	public function getCreatedAt()
	{
		return $this->createdAt->format('d/m/Y à H:i');
	}
	
	/**
	 * Set createdAt
	 *
	 * @param DateTime $createdAt
	 * @return News
	 */
	public function setCreatedAt(DateTime $createdAt)
	{
		$this->createdAt = $createdAt;
	
		return $this;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function prePersit()
	{
		$this->createdAt = new DateTime('now');
		$this->uri = URLify::filter($this->getTitle());
	}

	public function getListFields()
	{
		return array(
			'Titre de l\'actualité' => $this->getTitle(),
			'Créé le' => $this->getCreatedAt()
		);
	}

	/**
	 * String representation
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return $this->getTitle();
	}

	/**
	 * default contructor
	 */
	public function __construct()
	{
		$this->createdAt = new DateTime();
	}
}