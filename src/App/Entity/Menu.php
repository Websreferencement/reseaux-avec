<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Model\ListableDatasInterface;

/**
 * @ORM\Entity(repositoryClass="App\Entity\MenuRepository")
 * @ORM\Table(name="menu")
 */
class Menu implements ListableDatasInterface
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

	/**
	 * Get parent
	 * 
	 * @return Menu
	 */
	public function getParent()
	{
		return $this->parent;
	}
	
	/**
	 * Set parent
	 *
	 * @param Menu $parent
	 * @return Menu
	 */
	public function setParent($parent)
	{
		$this->parent = $parent;
	
		return $this;
	}

	/**
	 * Return the administration list fields
	 * 
	 * @return array
	 */
	public function getListFields()
	{
		return array(
			'name' => $this->name
		);
	}

	/**
	 * Object representation
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return $this->getName();
	}

	public function __construct()
	{
		$this->childs = new ArrayCollection();
	}

}