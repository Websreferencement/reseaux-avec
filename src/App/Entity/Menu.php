<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(respositoryClass="App\Entity\MenuRepository")
 * @ORM\Table(name="menu")
 */
class Menu
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=200)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $route;

	/**
	 * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent")
	 */
	private $childs;

	/**
	 * @ORM\ManyToOne(targetEntity="Menu", inversedBy="children")
	 */
	private $parent;

	/**
	 * @var Page $page
	 *
	 * @ORM\OneToOne(targetEntity="Page", mappedBy="menu")
	 */
	private $page;

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
	 * @return Menu
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
	 * @return Menu
	 */
	public function setName($name)
	{
		$this->name = $name;
	
		return $this;
	}

	/**
	 * Get route
	 * 
	 * @return string
	 */
	public function getRoute()
	{
		return $this->route;
	}
	
	/**
	 * Set route
	 *
	 * @param string $route
	 * @return Menu
	 */
	public function setRoute($route)
	{
		$this->route = $route;
	
		return $this;
	}

	/**
	 * Get childs
	 * 
	 * @return ArrayCollection
	 */
	public function getChilds()
	{
		return $this->childs;
	}
	
	/**
	 * add children
	 *
	 * @param Menu $children
	 * @return childs
	 */
	public function addChildren($children)
	{
		$this->childs[] = $children;
	
		return $this;
	}
	
	/**
	 * has children
	 *
	 * @param Menu $children
	 * @return boolean
	 */
	public function hasChildren($children)
	{
		foreach($this->childs as $item){
			if($item === $children){
	
				return true;
			}
		}
	
		return false;
	}

	/**
	 * Get page
	 * 
	 * @return Page
	 */
	public function getPage()
	{
		return $this->page;
	}
	
	/**
	 * Set page
	 *
	 * @param Page $page
	 * @return Menu
	 */
	public function setPage(Page $page)
	{
		$this->page = $page;
	
		return $this;
	}

	public function __construct()
	{
		$this->childs = new ArrayCollection();
	}

}