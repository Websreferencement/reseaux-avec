<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="video")
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
}