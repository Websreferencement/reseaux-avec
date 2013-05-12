<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use App\Model\ListableDatasInterface;

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
	 * @return DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
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
	 * @ORM\prePersist
	 */
	public function updateCreatedAt()
	{
		$this->createdAt = new DateTime('now');
	}

	public function getListFields()
	{
		return array(
			'Titre de l\'actualité' => $this->getTitle(),
			'Créé le' => $this->getCreatedAt()
		);
	}

	/**
	 * default contructor
	 */
	public function __construct()
	{
		$this->createdAt = new DateTime();
	}
}