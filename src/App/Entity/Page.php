<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Entity\PageRepository")
 * @ORM\Table(name="page")
 */
class Page
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
	 * @ORM\Column(type="string", length=255)
	 */
	private $title;

	/**
	 * @var string $content
	 *
	 * @ORM\Column(type="text")
	 */
	private $content;

	/**
	 * @var string $headTitle
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $headTitle;

	/**
	 * @var string $headDescription
	 *
	 * @ORM\Column(type="text")
	 */
	private $headDescription;

	/**
	 * @var integer $priority
	 *
	 * @ORM\Column(type="integer")
	 */
	private $priority;

	/**
	 * @var Menu $menu
	 *
	 * @ORM\OneToOne(targetEntity="Menu", inversedBy="page")
	 */
	private $menu;

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
	 * @return Page
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
	 * @return Page
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
	 * @return Page
	 */
	public function setContent($content)
	{
		$this->content = $content;
	
		return $this;
	}

	/**
	 * Get headTitle
	 * 
	 * @return string
	 */
	public function getHeadTitle()
	{
		return $this->headTitle;
	}
	
	/**
	 * Set headTitle
	 *
	 * @param string $headTitle
	 * @return Page
	 */
	public function setHeadTitle($headTitle)
	{
		$this->headTitle = $headTitle;
	
		return $this;
	}

	/**
	 * Get headDescription
	 * 
	 * @return string
	 */
	public function getHeadDescription()
	{
		return $this->headDescription;
	}
	
	/**
	 * Set headDescription
	 *
	 * @param string $headDescription
	 * @return Page
	 */
	public function setHeadDescription($headDescription)
	{
		$this->headDescription = $headDescription;
	
		return $this;
	}

	/**
	 * Get priority
	 * 
	 * @return integer
	 */
	public function getPriority()
	{
		return $this->priority;
	}
	
	/**
	 * Set priority
	 *
	 * @param integer $priority
	 * @return Page
	 */
	public function setPriority($priority)
	{
		$this->priority = $priority;
	
		return $this;
	}

	/**
	 * Get menu
	 * 
	 * @return Menu
	 */
	public function getMenu()
	{
		return $this->menu;
	}
	
	/**
	 * Set menu
	 *
	 * @param Menu $menu
	 * @return Page
	 */
	public function setMenu(Menu $menu)
	{
		$this->menu = $menu;
	
		return $this;
	}

	/**
	 * Representation of a Page
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return $this->getTitle();
	}
}