<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\ListableDatasInterface;

/**
 * @ORM\Entity(repositoryClass="App\Entity\PageRepository")
 * @ORM\Table(name="page")
 */
class Page implements ListableDatasInterface
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
	 * @var string $uri
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $uri;

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
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $headDescription;

	/**
	 * @var integer $priority
	 *
	 * @ORM\Column(type="decimal")
	 */
	private $priority;

	/**
	 * @var array $widgets
	 * 
	 * @ORM\Column(type="array")
	 */
	private $widgets;

	/**
	 * @var string $sidebar
	 *
	 * @ORM\Column(type="string", length=250)
	 */
	private $sidebar;

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
	 * Get widgets
	 * 
	 * @return array
	 */
	public function getWidgets()
	{
		return $this->widgets;
	}
	
	/**
	 * add widget
	 *
	 * @param Widget | String $widget
	 * @return widgets
	 */
	public function addWidget($widget)
	{
		$this->widgets[] = $widget;
	
		return $this;
	}
	
	/**
	 * has widget
	 *
	 * @param Widget | String $widget
	 * @return boolean
	 */
	public function hasWidget($widget)
	{
		foreach($this->widgets as $item){
			if($item === $widget){
	
				return true;
			}
		}
	
		return false;
	}
	
	/**
	 * remove widget
	 *
	 * @param Widget | String $widget
	 * @return widgets
	 */
	public function removeWidget($widget)
	{
		foreach($this->widgets as $key => $item){
			if($item === $widget){
	
				unset($this->widgets[$key]);
			}
		}
	
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
	 * @return Page
	 */
	public function setUri($uri)
	{
		$this->uri = $uri;
	
		return $this;
	}

	/**
	 * Return the available fields in the administration
	 * center
	 * 
	 * @return array
	 */
	public function getListFields()
	{
		return array(
			'Titre de la page' => $this->title,
			'Uri' => $this->uri
		);
	}

	/**
	 * Get sidebar
	 * 
	 * @return string
	 */
	public function getSidebar()
	{
		return $this->sidebar;
	}
	
	/**
	 * Set sidebar
	 *
	 * @param string $sidebar
	 * @return Page
	 */
	public function setSidebar($sidebar)
	{
		$this->sidebar = $sidebar;
	
		return $this;
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
        return 'ROLE_SUPER_ADMIN';
    }

    public function getCreateRole()
    {
        return 'ROLE_SUPER_ADMIN';
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

	/**
	 * Default constructor
	 */
	public function __construct()
	{
		$this->widgets = array();
	}
}
